#!/usr/bin/env bash
# shellcheck disable=SC2086

# === Configuration. === #
set -Eeuo pipefail

scripts_dir=$(dirname "$(readlink -f "$0")")
self_dir=$(realpath $scripts_dir/..)
source_dir=$self_dir/tests/sut

workspace_dir=${DCG_TMP_DIR:-/tmp}/dcg_sut
drupal_dir=$workspace_dir/drupal
cache_dir=$workspace_dir/cache
test_filter=${1:-'all'}

dcg_drupal_host=${DCG_DRUPAL_HOST:-'127.0.0.1'}
dcg_drupal_port=${DCG_DRUPAL_PORT:-'8085'}
dcg=$drupal_dir/vendor/bin/dcg
dcg_wd_url=${DCG_WD_URL:-'http://localhost:4444/wd/hub'}
dcg_drupal_version=${DCG_DRUPAL_VERSION:-'10.1.x'}
drupal_repo='https://git.drupalcode.org/project/drupal.git'

echo -----------------------------------------------
echo ' DRUPAL VERSION:' $dcg_drupal_version
echo ' DRUPAL DIR:    ' $drupal_dir
echo ' DCG:           ' $dcg
echo ' SOURCE_DIR:    ' $source_dir
echo ' SITE URL:      ' http://$dcg_drupal_host:$dcg_drupal_port
echo ' WD_URL:        ' $dcg_wd_url
echo -----------------------------------------------

function dcg_on_exit {
  local status=$?
  echo '🚩 Shutdown server'
  symfony server:stop --dir=$drupal_dir
  if [[ $status == 0 ]] ; then
    echo -e "\n\e[0;42m SUCCESS \e[0m"
  else
    echo -e "\n\e[0;41m FAIL \e[0m"
  fi
}
trap dcg_on_exit EXIT

# === Helper functions. === #

function dcg_module_install {
  $drupal_dir/drupal.php module:install "$@"
}

function dcg_module_uninstall {
  $drupal_dir/drupal.php module:uninstall "$@"
}

function dcg_phpcs {
  $drupal_dir/vendor/bin/phpcs -sp "$@"
}

function dcg_phpunit {
  SIMPLETEST_BASE_URL=http://$dcg_drupal_host:$dcg_drupal_port \
  SIMPLETEST_DB=sqlite://localhost//$drupal_dir/sites/default/files/dcg_test.sqlite \
  MINK_DRIVER_ARGS_WEBDRIVER='["chrome", {"chromeOptions": {"w3c": false, "args": ["--headless"]}}, "'$dcg_wd_url'"]' \
  $drupal_dir/vendor/bin/phpunit -c $drupal_dir/core "$@"
}

function dcg_label {
  echo -e "\n\e[30;43m -= $* =- \e[0m\n"
}

# === Create a site under testing. === #

if [[ -d $drupal_dir ]]; then
  chmod -R 777 $drupal_dir
  rm -rf $drupal_dir
fi

if [[ -d $cache_dir/$dcg_drupal_version ]]; then
  echo '🚩 Install Drupal from cache'
  cp -r $cache_dir/$dcg_drupal_version $drupal_dir
else
  echo '🚩 Clone Drupal core'
  git clone --depth 1 --branch $dcg_drupal_version $drupal_repo $drupal_dir
  echo '🚩 Install Composer dependencies'
  composer -d$drupal_dir install
  echo '🚩 Add DCG scripts and configuration'
  cp $scripts_dir/drupal.php $drupal_dir/
  cp -R $source_dir/example $drupal_dir/modules
  cp -R $source_dir/phpcs.xml $drupal_dir
  echo '🚩 Install Drupal'
  mkdir -m 777 $drupal_dir/sites/default/files
  php $drupal_dir/core/scripts/drupal install minimal
  cp -R $source_dir/dcg_test $drupal_dir/modules
  dcg_module_install dcg_test
  echo '🚩 Update cache'
  if [[ ! -d $cache_dir ]]; then
    mkdir -p $cache_dir
  fi
  cp -r $drupal_dir $cache_dir/$dcg_drupal_version
fi

echo '🚩 Install local DCG'
composer -d"$drupal_dir" config repositories.dcg "$(printf '{"type": "path", "url": "%s", "options": {"symlink": false}}' $self_dir)"
composer -d$drupal_dir require chi-teck/drupal-code-generator --with-all-dependencies
echo '————————————————————————————————————————————'
composer -d$drupal_dir show --ansi chi-teck/drupal-code-generator | head -n 10
echo '————————————————————————————————————————————'

echo '🚩 Start server'
symfony server:start --daemon --dir=$drupal_dir --port=$dcg_drupal_port --no-tls
export SUT_TEST=1

# === Tests === #
echo '🚩 Run tests'
# --- Test forms --- #
if [[ $test_filter = all || $test_filter = form ]]; then
  dcg_label Form

  module_machine_name=foo
  module_dir=$drupal_dir/modules/$module_machine_name

  cp -R $source_dir/$module_machine_name $module_dir
  cd $module_dir

  $dcg form:simple -a foo -a Foo -a SimpleForm -a Yes -a foo.simple_form -a /admin/config/foo/simple -a Example -a 'access administration pages'
  $dcg form:config -a foo -a Foo -a SettingsForm -a Yes -a foo.config_form -a /admin/config/foo/settings -a Example -a 'access administration pages' -a No
  $dcg form:confirm -a foo -a Foo -a ConfirmForm -a Yes -a foo.confirm_form -a /admin/config/foo/confirm -a Example -a 'access administration pages'

  dcg_phpcs --exclude=DrupalPractice.Yaml.RoutingAccess .
  dcg_module_install $module_machine_name
  dcg_phpunit tests
  dcg_module_uninstall $module_machine_name
fi

# --- Test module components --- #
if [[ $test_filter = all || $test_filter = module_component ]]; then
  dcg_label Module component

  module_machine_name=bar
  module_dir=$drupal_dir/modules/$module_machine_name

  cp -R $source_dir/$module_machine_name $module_dir
  cd $module_dir

  $dcg controller -a bar -a Bar -a BarController -a No -a Yes -a bar.example -a /bar/example -a Example -a 'access content'
  $dcg install-file -a bar -a Bar
  $dcg javascript -a bar -a Bar -a heavy-metal.js -a Yes -a heavy_metal
  $dcg service-provider -a bar -a Bar -a Yes -a Yes
  $dcg template -a bar -a Bar -a example -a Yes -a Yes
  $dcg layout -a bar -a Foo -a foo -a my -a Yes -a Yes
  $dcg render-element -a bar -a example -a Example
  $dcg hook -a bar -a Bar -a countries_alter

  $dcg field \
    -a bar -a Bar -a 'Example 1' -a bar_example_1 -a 10 \
    -a 'Value 1' -a value_1 -a Boolean -a No \
    -a 'Value 2' -a value_2 -a Text -a No -a No \
    -a 'Value 3' -a value_3 -a 'Text (long)' -a No \
    -a 'Value 4' -a value_4 -a Integer -a No -a No \
    -a 'Value 5' -a value_5 -a Float -a No -a No \
    -a 'Value 6' -a value_6 -a Numeric -a No -a No \
    -a 'Value 7' -a value_7 -a Email -a No -a No \
    -a 'Value 8' -a value_8 -a Telephone -a No -a No \
    -a 'Value 9' -a value_9 -a Url -a No -a No \
    -a 'Value 10' -a value_10 -a Date -a 'Date only' -a No -a No \
    -a No -a No -a No -a No -a No -a No

  $dcg field \
    -a bar -a Bar -a 'Example 2' -a bar_example_2 -a 10 \
    -a 'Value 1' -a value_1 -a Boolean -a Yes \
    -a 'Value 2' -a value_2 -a Text -a Yes -a Yes \
    -a 'Value 3' -a value_3 -a 'Text (long)' -a Yes \
    -a 'Value 4' -a value_4 -a Integer -a Yes -a No \
    -a 'Value 5' -a value_5 -a Float -a Yes -a Yes \
    -a 'Value 6' -a value_6 -a Numeric -a Yes -a No \
    -a 'Value 7' -a value_7 -a Email -a Yes -a Yes \
    -a 'Value 8' -a value_8 -a Telephone -a Yes -a No \
    -a 'Value 9' -a value_9 -a Url -a Yes -a Yes \
    -a 'Value 10' -a value_10 -a Date -a 'Date and time' -a Yes -a No \
    -a No -a No -a No -a No -a No -a No

  $dcg field \
    -a bar -a Bar -a 'Example 3' -a bar_example_3 -a 5 \
    -a 'Value 1' -a value_1 -a Boolean -a No \
    -a 'Value 2' -a value_2 -a Text -a No -a No \
    -a 'Value 3' -a value_3 -a 'Text (long)' -a No \
    -a 'Value 4' -a value_4 -a Email -a No -a No \
    -a 'Value 5' -a value_5 -a Url -a No -a No \
    -a Yes -a Yes -a Yes -a Yes -a Yes -a Yes

  dcg_phpcs .
  dcg_module_install $module_machine_name
  dcg_phpunit tests
  dcg_module_uninstall $module_machine_name
fi

# --- Test plugins --- #
if [[ $test_filter = all || $test_filter = plugin ]]; then
  dcg_label Plugin

  module_machine_name=qux
  module_dir=$drupal_dir/modules/$module_machine_name

  cp -R $source_dir/$module_machine_name $module_dir
  cd $module_dir

  $dcg plugin:field:formatter -a qux -a Example -a qux_example -a ExampleFormatter -a Yes
  $dcg plugin:field:type -a qux -a Example -a qux_example -a ExampleItem -a Yes -a Yes
  $dcg plugin:field:widget -a qux -a Example -a qux_example -a ExampleWidget -a Yes -a No

  $dcg plugin:migrate:source -a qux -a foo -a Foo -a 'SQL'
  $dcg plugin:migrate:source -a qux -a bar -a Bar -a 'Other'
  $dcg plugin:migrate:process -a qux -a example -a Example -a No
  $dcg plugin:migrate:destination -a qux -a example -a Example -a No

  $dcg plugin:views:argument-default -a qux -a Example -a qux_example -a Example -a Yes -a No
  $dcg plugin:views:field -a qux -a Example -a qux_example -a Example -a Yes -a No
  $dcg plugin:views:style -a qux -a Qux -a Example -a qux_example -a Example -a Yes -a No

  $dcg plugin:action -a qux -a 'Update node field' -a qux_update_node_field -a UpdateNodeField -a DCG -a node -a Yes -a No
  $dcg plugin:block -a qux -a Example -a example -a ExampleBlock -a DCG -a Yes -a No -a No
  $dcg plugin:ckeditor -a qux -a 'Pooh Bear' -a qux_pooh_bear
  $dcg plugin:condition -a qux -a Example -a example -a Example -a No
  $dcg plugin:entity-reference-selection -a qux -a Qux -a node -a Example -a qux_example -a Example -a Yes
  $dcg plugin:filter -a qux -a Qux -a Example -a example -a Example -a 'HTML restrictor' -a Yes -a No
  $dcg plugin:menu-link -a qux -a FooExampleLink -a No
  $dcg plugin:queue-worker -a qux -a Example -a qux_example -a Example -a No
  $dcg plugin:rest-resource -a qux -a Example -a qux_example -a ExampleResource
  $dcg plugin:constraint -a qux -a Qux -a Example -a QuxConstraint -a ExampleConstraint -a 'Raw value' -a No

  dcg_phpcs .
  dcg_module_install $module_machine_name
  echo 'Build CKEditor plugin...'
  npm install && npm run build
  dcg_phpunit tests
  dcg_module_uninstall $module_machine_name
fi

# --- Test services --- #
if [[ $test_filter = all || $test_filter = service ]]; then
  dcg_label Service

  module_machine_name=zippo
  module_dir=$drupal_dir/modules/$module_machine_name

  cp -R $source_dir/$module_machine_name $module_dir
  cd $module_dir

  $dcg service:access-checker -a zippo -a _zippo -a ZippoAccessChecker -a No
  $dcg service:breadcrumb-builder -a zippo -a ZippoBreadcrumbBuilder -a No
  $dcg service:custom -a zippo -a zippo.foo -a Foo -a Yes -a Yes -a entity_type.manager -a
  $dcg service:event-subscriber -a zippo -a Zippo -a FooSubscriber -a Yes -a messenger -a
  $dcg service:logger -a zippo -a FileLog -a No
  $dcg service:middleware -a zippo -a BarMiddelware -a No
  $dcg service:param-converter -a zippo -a example -a ExampleParamConverter -a No
  $dcg service:route-subscriber -a zippo -a ZippoRouterSubscibrer -a No
  $dcg service:theme-negotiator -a zippo -a ZippoThemeNegotiator -a No
  $dcg service:twig-extension -a zippo -a ZippoTwigExtension -a No
  $dcg service:path-processor -a zippo -a PathProcessorZippo -a No
  $dcg service:request-policy -a zippo -a Example -a Yes -a 'entity_type.manager' -a
  $dcg service:response-policy -a zippo -a ExampleResponsePolicy -a No
  $dcg service:uninstall-validator -a zippo -a Zippo -a ExampleUninstallValidator -a No
  $dcg service:cache-context -a zippo -a example -a ExampleCacheContext -a UserCacheContextBase -a Yes

  dcg_phpcs $module_dir
  dcg_module_install $module_machine_name
  dcg_phpunit tests
  # Do not uninstall this module as the uninstall validator prevents it.
fi

# --- Test YML --- #
if [[ $test_filter = all || $test_filter = yml ]]; then
  dcg_label YML

  module_machine_name=yety
  module_dir=$drupal_dir/modules/$module_machine_name

  cp -R $source_dir/$module_machine_name $module_dir
  cd $module_dir

  $dcg yml:links:action -a yety
  $dcg yml:links:contextual -a yety
  $dcg yml:links:menu -a yety
  $dcg yml:links:task -a yety
  $dcg yml:module-libraries -a yety
  $dcg yml:permissions -a yety
  $dcg yml:routing -a yety -a Yety
  $dcg yml:services -a yety -a Yety

  dcg_phpcs $module_dir
  dcg_module_install $module_machine_name
  dcg_phpunit tests
  dcg_module_uninstall $module_machine_name
fi

# --- Test tests --- #
if [[ $test_filter = all || $test_filter = test ]]; then
  dcg_label Test

  module_machine_name=xerox
  module_dir=$drupal_dir/modules/$module_machine_name

  cp -R $source_dir/$module_machine_name $module_dir
  cd $module_dir

  $dcg test:browser -a xerox -a Xerox -a ExampleTest
  $dcg test:kernel -a xerox -a Xerox -a ExampleTest
  $dcg test:nightwatch -a xerox -a Xerox -a example
  $dcg test:unit -a xerox -a Xerox -a ExampleTest
  $dcg test:webdriver -a xerox -a Xerox -a ExampleTest

  dcg_phpcs --exclude=Generic.CodeAnalysis.UselessOverridingMethod $module_dir
  dcg_module_install $module_machine_name
  dcg_phpunit tests
  dcg_module_uninstall $module_machine_name
fi

# --- Test theme components --- #
if [[ $test_filter = all || $test_filter = theme_component ]]; then
  dcg_label Theme component

  module_machine_name=plantain
  module_dir=$drupal_dir/modules/$module_machine_name

  theme_machine_name=shreya
  theme_dir=$drupal_dir/themes/$theme_machine_name
  cp -R $source_dir/$theme_machine_name $theme_dir

  cp -R $source_dir/$module_machine_name $module_dir
  cd $module_dir

  $dcg yml:breakpoints -a shreya
  $dcg theme-settings -a shreya -a Shreya
  $dcg yml:theme-libraries -a shreya

  dcg_phpcs $theme_dir

  dcg_phpcs --exclude=Generic.CodeAnalysis.UselessOverridingMethod $module_dir
  dcg_module_install $module_machine_name
  dcg_phpunit tests
  dcg_module_uninstall $module_machine_name
fi

# --- Test plugin manager --- #
if [[ $test_filter = all || $test_filter = plugin_manager ]]; then
  dcg_label Plugin manager

  module_machine_name=lamda
  module_dir=$drupal_dir/modules/$module_machine_name
  cp -R $source_dir/$module_machine_name $module_dir
  cd $module_dir

  $dcg plugin-manager -a lamda -a Lamda -a alpha -a Annotation
  $dcg plugin-manager -a lamda -a Lamda -a beta -a YAML
  $dcg plugin-manager -a lamda -a Lamda -a gamma -a Hook

  dcg_phpcs .
  dcg_module_install $module_machine_name
  dcg_phpunit tests
  dcg_module_uninstall $module_machine_name
fi

# --- Test configuration entity --- #
if [[ $test_filter = all || $test_filter = configuration_entity ]]; then
  dcg_label Configuration entity

  module_machine_name=wine
  module_dir=$drupal_dir/modules/$module_machine_name
  cp -R $source_dir/$module_machine_name $module_dir
  cd $module_dir

  $dcg entity:configuration -a wine -a Wine -a Example -a example

  dcg_phpcs .
  dcg_module_install $module_machine_name
  dcg_phpunit tests
  dcg_module_uninstall $module_machine_name
fi

# --- Test content entity --- #
if [[ $test_filter = all || $test_filter = content_entity ]]; then
  dcg_label 'Content entity (with bundles and fields)'

  module_machine_name=nigma
  module_dir=$drupal_dir/modules/$module_machine_name
  cp -R $source_dir/$module_machine_name $module_dir
  cd $module_dir

  $dcg entity:content \
    -a nigma -a Nigma -a Example -a example -a Example -a /admin/content/example \
    -a Yes -a Yes -a Yes -a Yes -a Yes -a Yes -a Yes -a Yes -a Yes -a Yes -a Yes -a Yes -a Yes -a Yes

  dcg_phpcs .
  dcg_module_install $module_machine_name
  dcg_phpunit tests
  dcg_module_uninstall $module_machine_name

  dcg_label 'Content entity (with fields)'

  module_machine_name=sigma
  module_dir=$drupal_dir/modules/$module_machine_name
  cp -R $source_dir/$module_machine_name $module_dir
  cd $module_dir

  $dcg entity:content \
    -a sigma -a Sigma -a Example -a example -a Example -a /example \
    -a Yes -a No -a No -a No -a Yes -a No -a No -a Yes -a No -a No -a No -a No -a No -a No

  dcg_phpcs .
  dcg_module_install $module_machine_name
  dcg_phpunit tests
  dcg_module_uninstall $module_machine_name

  dcg_label 'Content entity (without bundles, fields and canonical page)'

  module_machine_name=figma
  module_dir=$drupal_dir/modules/$module_machine_name
  cp -R $source_dir/$module_machine_name $module_dir
  cd $module_dir

  $dcg entity:content \
    -a figma -a Figma -a Example -a example -a Example -a /example \
    -a No -a No -a No -a No -a No -a No -a No -a Yes -a No -a No -a No -a No -a No

  dcg_phpcs .
  dcg_module_install $module_machine_name
  dcg_phpunit tests
  dcg_module_uninstall $module_machine_name
fi

# --- Test bundle class --- #
if [[ $test_filter = all || $test_filter = bundle_class ]]; then
  dcg_label 'Bundle classes'

  module_machine_name=acme
  module_dir=$drupal_dir/modules/$module_machine_name
  cp -R $source_dir/$module_machine_name $module_dir
  cd $module_dir

  $dcg entity:bundle-class -a acme -a Acme -a User -a UserBundle -a Yes -a UserBase
  dcg_phpcs $module_dir
  dcg_module_install $module_machine_name
  dcg_phpunit tests
  dcg_module_uninstall $module_machine_name
fi

# --- Test module --- #
if [[ $test_filter = all || $test_filter = module ]]; then
  dcg_label Module

  module_machine_name=peach
  module_dir=$drupal_dir/modules/$module_machine_name
  cp -R $source_dir/$module_machine_name $module_dir
  cd $module_dir

  $dcg module -d $drupal_dir/modules -a Peach -a peach -a 'Simple module generated by DCG.' \
    -a DCG -a 'drupal:views, drupal:node, drupal:action' -a Yes -a Yes -a Yes

  dcg_phpcs $module_dir
  dcg_module_install $module_machine_name
  dcg_phpunit tests
  dcg_module_uninstall $module_machine_name
fi

# --- Test theme --- #
if [[ $test_filter = all || $test_filter = theme ]]; then
  dcg_label Theme

  module_machine_name=tandoor
  module_dir=$drupal_dir/modules/$module_machine_name

  cp -r $source_dir/$module_machine_name $module_dir
  cd $module_dir

  theme_machine_name=azalea
  theme_dir=$drupal_dir/themes/$theme_machine_name

  $dcg theme -d $drupal_dir/themes -a Azalea -a azalea -a claro -a 'Simple responsive theme generated by DCG.' \
    -a DCG -a Yes -a Yes

  dcg_phpcs $theme_dir
  dcg_phpcs $module_dir
  dcg_module_install $module_machine_name
  dcg_phpunit tests
  dcg_module_uninstall $module_machine_name
fi

# --- Test module --- #
if [[ $test_filter = all || $test_filter = console ]]; then
  dcg_label 'Console Commands'

  module_machine_name=sonata
  module_dir=$drupal_dir/modules/$module_machine_name
  cp -R $source_dir/$module_machine_name $module_dir
  cd $module_dir

  $dcg console:symfony-command -d $drupal_dir/modules -a sonata -a Sonata -a 'sonata:example' \
       -a 'Simple command generated by DCG.' -a example -a ExampleCommand -a Yes -a No

  dcg_phpcs $module_dir
  dcg_module_install $module_machine_name
  dcg_phpunit tests
  dcg_module_uninstall $module_machine_name
fi
