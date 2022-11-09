#!/usr/bin/env bash
# shellcheck disable=SC2086

# === Configuration. === #
set -Eeuo pipefail

SCRIPTS_DIR=$(dirname "$(readlink -f "$0")");
SELF_DIR=$(realpath $SCRIPTS_DIR/..)
SOURCE_DIR=$SELF_DIR/tests/sut

WORKSPACE_DIR=${DCG_TMP_DIR:-/tmp}/dcg_sut
DRUPAL_DIR=$WORKSPACE_DIR/drupal
CACHE_DIR=$WORKSPACE_DIR/cache

DCG_DRUPAL_HOST=${DCG_DRUPAL_HOST:-'127.0.0.1'}
DCG_DRUPAL_PORT=${DCG_DRUPAL_PORT:-'8085'}
DCG=$DRUPAL_DIR/vendor/bin/dcg
DCG_WD_URL=${DCG_WD_URL:-'http://localhost:4444/wd/hub'}
DRUPAL_REPO='https://git.drupalcode.org/project/drupal.git'
DCG_TEST_FILTER=${1:-'all'}

if [[ -z ${DCG_DRUPAL_VERSION:-} ]]; then
  DCG_DRUPAL_VERSION=$(git ls-remote -h $DRUPAL_REPO | grep -o '10\.0\.x' | tail -n1)
fi

echo -----------------------------------------------
echo ' DRUPAL VERSION:' $DCG_DRUPAL_VERSION
echo ' DRUPAL DIR:    ' $DRUPAL_DIR
echo ' DCG:           ' $DCG
echo ' SOURCE_DIR:    ' $SOURCE_DIR
echo ' SITE URL:      ' http://$DCG_DRUPAL_HOST:$DCG_DRUPAL_PORT
echo ' WD_URL:        ' $DCG_WD_URL
echo -----------------------------------------------

function dcg_on_exit {
  local STATUS=$?
  echo '🚩 Shutdown server'
  symfony server:stop --dir=$DRUPAL_DIR
  if [[ $STATUS == 0 ]] ; then
    echo -e "\n\e[0;42m SUCCESS \e[0m"
  else
    echo -e "\n\e[0;41m FAIL \e[0m"
  fi
}
trap dcg_on_exit EXIT

# === Helper functions. === #

function dcg_module_install {
  $DRUPAL_DIR/drupal.php module:install "$@"
}

function dcg_module_uninstall {
  $DRUPAL_DIR/drupal.php module:uninstall "$@"
}

function dcg_phpcs {
  $DRUPAL_DIR/vendor/bin/phpcs -sp "$@"
}

function dcg_phpunit {
  SIMPLETEST_BASE_URL=http://$DCG_DRUPAL_HOST:$DCG_DRUPAL_PORT \
  SIMPLETEST_DB=sqlite://localhost//$DRUPAL_DIR/sites/default/files/dcg_test.sqlite \
  MINK_DRIVER_ARGS_WEBDRIVER='["chrome", {"chromeOptions": {"w3c": false, "args": ["--headless"]}}, "'$DCG_WD_URL'"]' \
  $DRUPAL_DIR/vendor/bin/phpunit -c $DRUPAL_DIR/core "$@"
}

function dcg_label {
  echo -e "\n\e[30;43m -= $* =- \e[0m\n"
}

# === Create a site under testing. === #

if [[ -d $DRUPAL_DIR ]]; then
  chmod -R 777 $DRUPAL_DIR
  rm -rf $DRUPAL_DIR
fi

if [[ -d $CACHE_DIR/$DCG_DRUPAL_VERSION ]]; then
  echo '🚩 Install Drupal from cache'
  cp -r $CACHE_DIR/$DCG_DRUPAL_VERSION $DRUPAL_DIR
else
  echo '🚩 Clone Drupal core'
  git clone --depth 1 --branch $DCG_DRUPAL_VERSION $DRUPAL_REPO $DRUPAL_DIR
  echo '🚩 Install Composer dependencies'
  composer -d$DRUPAL_DIR install
  echo '🚩 Add DCG scripts and configuration'
  cp $SCRIPTS_DIR/drupal.php $DRUPAL_DIR/
  cp -R $SOURCE_DIR/example $DRUPAL_DIR/modules
  cp -R $SOURCE_DIR/phpcs.xml $DRUPAL_DIR
  echo '🚩 Install Drupal'
  mkdir -m 777 $DRUPAL_DIR/sites/default/files
  php $DRUPAL_DIR/core/scripts/drupal install minimal
  cp -R $SOURCE_DIR/dcg_test $DRUPAL_DIR/modules
  dcg_module_install dcg_test
  echo '🚩 Update cache'
  if [[ ! -d $CACHE_DIR ]]; then
    mkdir -p $CACHE_DIR
  fi
  cp -r $DRUPAL_DIR $CACHE_DIR/$DCG_DRUPAL_VERSION
fi

echo '🚩 Install local DCG'
composer -d"$DRUPAL_DIR" config repositories.dcg "$(printf '{"type": "path", "url": "%s", "options": {"symlink": false}}' $SELF_DIR)"
composer -d$DRUPAL_DIR require chi-teck/drupal-code-generator
echo '————————————————————————————————————————————'
composer -d$DRUPAL_DIR show --ansi chi-teck/drupal-code-generator | head -n 10
echo '————————————————————————————————————————————'

echo '🚩 Start server'
symfony server:start --daemon --dir=$DRUPAL_DIR --port=$DCG_DRUPAL_PORT --no-tls
export SUT_TEST=1

# === Tests === #
echo '🚩 Run tests'
# --- Test forms --- #
if [[ $DCG_TEST_FILTER = all || $DCG_TEST_FILTER = form ]]; then
  dcg_label Form

  MODULE_MACHINE_NAME=foo
  MODULE_DIR=$DRUPAL_DIR/modules/$MODULE_MACHINE_NAME

  cp -R $SOURCE_DIR/$MODULE_MACHINE_NAME $MODULE_DIR
  cd $MODULE_DIR

  $DCG form:simple -a foo -a Foo -a SimpleForm -a Yes -a foo.simple_form -a /admin/config/foo/simple -a Example -a 'access administration pages'
  $DCG form:config -a foo -a Foo -a SettingsForm -a Yes -a foo.config_form -a /admin/config/foo/settings -a Example -a 'access administration pages' -a No
  $DCG form:confirm -a foo -a Foo -a ConfirmForm -a Yes -a foo.confirm_form -a /admin/config/foo/confirm -a Example -a 'access administration pages'

  dcg_phpcs --exclude=DrupalPractice.Yaml.RoutingAccess .
  dcg_module_install $MODULE_MACHINE_NAME
  dcg_phpunit tests
  dcg_module_uninstall $MODULE_MACHINE_NAME
fi

# --- Test module components --- #
if [[ $DCG_TEST_FILTER = all || $DCG_TEST_FILTER = module_component ]]; then
  dcg_label Module component

  MODULE_MACHINE_NAME=bar
  MODULE_DIR=$DRUPAL_DIR/modules/$MODULE_MACHINE_NAME

  cp -R $SOURCE_DIR/$MODULE_MACHINE_NAME $MODULE_DIR
  cd $MODULE_DIR

  $DCG controller -a bar -a Bar -a BarController -a No -a Yes -a bar.example -a /bar/example -a Example -a 'access content'
  $DCG install-file -a bar -a Bar
  $DCG javascript -a bar -a Bar -a heavy-metal.js -a Yes -a heavy_metal
  $DCG service-provider -a bar -a Bar -a Yes -a Yes
  $DCG template -a bar -a Bar -a example -a Yes -a Yes
  $DCG layout -a bar -a Foo -a foo -a my -a Yes -a Yes
  $DCG render-element -a bar -a example -a Example
  $DCG hook -a bar -a Bar -a countries_alter

  $DCG field \
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

  $DCG field \
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

  $DCG field \
    -a bar -a Bar -a 'Example 3' -a bar_example_3 -a 5 \
    -a 'Value 1' -a value_1 -a Boolean -a No \
    -a 'Value 2' -a value_2 -a Text -a No -a No \
    -a 'Value 3' -a value_3 -a 'Text (long)' -a No \
    -a 'Value 4' -a value_4 -a Email -a No -a No \
    -a 'Value 5' -a value_5 -a Url -a No -a No \
    -a Yes -a Yes -a Yes -a Yes -a Yes -a Yes

  dcg_phpcs .
  dcg_module_install $MODULE_MACHINE_NAME
  dcg_phpunit tests
  dcg_module_uninstall $MODULE_MACHINE_NAME
fi

# --- Test plugins --- #
if [[ $DCG_TEST_FILTER = all || $DCG_TEST_FILTER = plugin ]]; then
  dcg_label Plugin

  MODULE_MACHINE_NAME=qux
  MODULE_DIR=$DRUPAL_DIR/modules/$MODULE_MACHINE_NAME

  cp -R $SOURCE_DIR/$MODULE_MACHINE_NAME $MODULE_DIR
  cd $MODULE_DIR

  $DCG plugin:field:formatter -a qux -a Example -a qux_example -a ExampleFormatter -a Yes
  $DCG plugin:field:type -a qux -a Example -a qux_example -a ExampleItem -a Yes -a Yes
  $DCG plugin:field:widget -a qux -a Example -a qux_example -a ExampleWidget -a Yes

  $DCG plugin:migrate:process -a qux -a example -a Example

  $DCG plugin:views:argument-default -a qux -a Example -a qux_example -a Example -a Yes -a No
  $DCG plugin:views:field -a qux -a Example -a qux_example -a Example -a Yes -a No
  $DCG plugin:views:style -a qux -a Qux -a Example -a qux_example -a Example -a Yes -a No

  $DCG plugin:action -a qux -a 'Update node title' -a qux_update_node_title -a UpdateNodeTitle -a DCG -a Yes
  $DCG plugin:block -a qux -a Example -a example -a ExampleBlock -a DCG -a Yes -a No -a No
  $DCG plugin:ckeditor -a qux -a 'Pooh Bear' -a qux_pooh_bear
  $DCG plugin:condition -a qux -a Example -a example -a Example
  $DCG plugin:entity-reference-selection -a qux -a Qux -a node -a Example -a qux_example -a Example -a Yes
  $DCG plugin:filter -a qux -a Qux -a Example -a example -a Example -a 'HTML restrictor'
  $DCG plugin:menu-link -a qux -a FooExampleLink
  $DCG plugin:queue-worker -a qux -a Example -a qux_example -a Example
  $DCG plugin:rest-resource -a qux -a Example -a qux_example -a ExampleResource

  dcg_phpcs .
  dcg_module_install $MODULE_MACHINE_NAME
  echo 'Build CKEditor plugin...'
  npm install && npm run build
  dcg_phpunit tests
  dcg_module_uninstall $MODULE_MACHINE_NAME
fi

# --- Test services --- #
if [[ $DCG_TEST_FILTER = all || $DCG_TEST_FILTER = service ]]; then
  dcg_label Service

  MODULE_MACHINE_NAME=zippo
  MODULE_DIR=$DRUPAL_DIR/modules/$MODULE_MACHINE_NAME

  cp -R $SOURCE_DIR/$MODULE_MACHINE_NAME $MODULE_DIR
  cd $MODULE_DIR

  $DCG service:access-checker -a zippo -a _zippo -a ZippoAccessChecker -a No
  $DCG service:breadcrumb-builder -a zippo -a ZippoBreadcrumbBuilder -a No
  $DCG service:custom -a zippo -a zippo.foo -a Foo -a Yes -a Yes -a entity_type.manager -a
  $DCG service:event-subscriber -a zippo -a Zippo -a FooSubscriber -a Yes -a messenger -a
  $DCG service:logger -a zippo -a FileLog -a No
  $DCG service:middleware -a zippo -a BarMiddelware -a No
  $DCG service:param-converter -a zippo -a example -a ExampleParamConverter -a No
  $DCG service:route-subscriber -a zippo -a ZippoRouterSubscibrer -a No
  $DCG service:theme-negotiator -a zippo -a ZippoThemeNegotiator -a No
  $DCG service:twig-extension -a zippo -a ZippoTwigExtension -a No
  $DCG service:path-processor -a zippo -a PathProcessorZippo -a No
  $DCG service:request-policy -a zippo -a Example -a Yes -a 'entity_type.manager' -a
  $DCG service:response-policy -a zippo -a ExampleResponsePolicy -a No
  $DCG service:uninstall-validator -a zippo -a Zippo -a ExampleUninstallValidator -a No
  $DCG service:cache-context -a zippo -a example -a ExampleCacheContext -a UserCacheContextBase -a Yes

  dcg_phpcs $MODULE_DIR
  dcg_module_install $MODULE_MACHINE_NAME
  dcg_phpunit tests
  # Do not uninstall this module as the uninstall validator prevents it.
fi

# --- Test YML --- #
if [[ $DCG_TEST_FILTER = all || $DCG_TEST_FILTER = yml ]]; then
  dcg_label YML

  MODULE_MACHINE_NAME=yety
  MODULE_DIR=$DRUPAL_DIR/modules/$MODULE_MACHINE_NAME

  cp -R $SOURCE_DIR/$MODULE_MACHINE_NAME $MODULE_DIR
  cd $MODULE_DIR

  $DCG yml:links:action -a yety
  $DCG yml:links:contextual -a yety
  $DCG yml:links:menu -a yety
  $DCG yml:links:task -a yety
  $DCG yml:module-libraries -a yety
  $DCG yml:permissions -a yety
  $DCG yml:routing -a yety -a Yety
  $DCG yml:services -a yety -a Yety

  dcg_phpcs $MODULE_DIR
  dcg_module_install $MODULE_MACHINE_NAME
  dcg_phpunit tests
  dcg_module_uninstall $MODULE_MACHINE_NAME
fi

# --- Test tests --- #
if [[ $DCG_TEST_FILTER = all || $DCG_TEST_FILTER = test ]]; then
  dcg_label Test

  MODULE_MACHINE_NAME=xerox
  MODULE_DIR=$DRUPAL_DIR/modules/$MODULE_MACHINE_NAME

  cp -R $SOURCE_DIR/$MODULE_MACHINE_NAME $MODULE_DIR
  cd $MODULE_DIR

  $DCG test:browser -a xerox -a Xerox -a ExampleTest
  $DCG test:kernel -a xerox -a Xerox -a ExampleTest
  $DCG test:nightwatch -a xerox -a Xerox -a example
  $DCG test:unit -a xerox -a Xerox -a ExampleTest
  $DCG test:webdriver -a xerox -a Xerox -a ExampleTest

  dcg_phpcs --exclude=Generic.CodeAnalysis.UselessOverridingMethod $MODULE_DIR
  dcg_module_install $MODULE_MACHINE_NAME
  dcg_phpunit tests
  dcg_module_uninstall $MODULE_MACHINE_NAME
fi

# --- Test theme components --- #
if [[ $DCG_TEST_FILTER = all || $DCG_TEST_FILTER = theme_component ]]; then
  dcg_label Theme component

  MODULE_MACHINE_NAME=plantain
  MODULE_DIR=$DRUPAL_DIR/modules/$MODULE_MACHINE_NAME

  THEME_MACHINE_NAME=shreya
  THEME_DIR=$DRUPAL_DIR/themes/$THEME_MACHINE_NAME
  cp -R $SOURCE_DIR/$THEME_MACHINE_NAME $THEME_DIR

  cp -R $SOURCE_DIR/$MODULE_MACHINE_NAME $MODULE_DIR
  cd $MODULE_DIR

  $DCG yml:breakpoints -a shreya
  $DCG theme-settings -a shreya -a Shreya
  $DCG yml:theme-libraries -a shreya

  dcg_phpcs $THEME_DIR

  dcg_phpcs --exclude=Generic.CodeAnalysis.UselessOverridingMethod $MODULE_DIR
  dcg_module_install $MODULE_MACHINE_NAME
  dcg_phpunit tests
  dcg_module_uninstall $MODULE_MACHINE_NAME
fi

# --- Test plugin manager --- #
if [[ $DCG_TEST_FILTER = all || $DCG_TEST_FILTER = plugin_manager ]]; then
  dcg_label Plugin manager

  MODULE_MACHINE_NAME=lamda
  MODULE_DIR=$DRUPAL_DIR/modules/$MODULE_MACHINE_NAME
  cp -R $SOURCE_DIR/$MODULE_MACHINE_NAME $MODULE_DIR
  cd $MODULE_DIR

  $DCG plugin-manager -a lamda -a Lamda -a alpha -a Annotation
  $DCG plugin-manager -a lamda -a Lamda -a beta -a YAML
  $DCG plugin-manager -a lamda -a Lamda -a gamma -a Hook

  dcg_phpcs .
  dcg_module_install $MODULE_MACHINE_NAME
  dcg_phpunit tests
  dcg_module_uninstall $MODULE_MACHINE_NAME
fi

# --- Test configuration entity --- #
if [[ $DCG_TEST_FILTER = all || $DCG_TEST_FILTER = configuration_entity ]]; then
  dcg_label Configuration entity

  MODULE_MACHINE_NAME=wine
  MODULE_DIR=$DRUPAL_DIR/modules/$MODULE_MACHINE_NAME
  cp -R $SOURCE_DIR/$MODULE_MACHINE_NAME $MODULE_DIR
  cd $MODULE_DIR

  $DCG entity:configuration -a wine -a Wine -a Example -a example

  dcg_phpcs .
  dcg_module_install $MODULE_MACHINE_NAME
  dcg_phpunit tests
  dcg_module_uninstall $MODULE_MACHINE_NAME
fi

# --- Test content entity --- #
if [[ $DCG_TEST_FILTER = all || $DCG_TEST_FILTER = content_entity ]]; then
  dcg_label 'Content entity (with bundles and fields)'

  MODULE_MACHINE_NAME=nigma
  MODULE_DIR=$DRUPAL_DIR/modules/$MODULE_MACHINE_NAME
  cp -R $SOURCE_DIR/$MODULE_MACHINE_NAME $MODULE_DIR
  cd $MODULE_DIR

  $DCG entity:content \
    -a nigma -a Nigma -a Example -a example -a /admin/content/example \
    -a Yes -a Yes -a Yes -a Yes -a Yes -a Yes -a Yes -a Yes -a Yes -a Yes -a Yes -a Yes -a Yes -a Yes

  dcg_phpcs .
  dcg_module_install $MODULE_MACHINE_NAME
  dcg_phpunit tests
  dcg_module_uninstall $MODULE_MACHINE_NAME

  dcg_label 'Content entity (with fields)'

  MODULE_MACHINE_NAME=sigma
  MODULE_DIR=$DRUPAL_DIR/modules/$MODULE_MACHINE_NAME
  cp -R $SOURCE_DIR/$MODULE_MACHINE_NAME $MODULE_DIR
  cd $MODULE_DIR

  $DCG entity:content \
    -a sigma -a Sigma -a Example -a example -a /example \
    -a Yes -a No -a No -a No -a Yes -a No -a No -a Yes -a No -a No -a No -a No -a No -a No

  dcg_phpcs .
  dcg_module_install $MODULE_MACHINE_NAME
  dcg_phpunit tests
  dcg_module_uninstall $MODULE_MACHINE_NAME

  dcg_label 'Content entity (without bundles, fields and canonical page)'

  MODULE_MACHINE_NAME=figma
  MODULE_DIR=$DRUPAL_DIR/modules/$MODULE_MACHINE_NAME
  cp -R $SOURCE_DIR/$MODULE_MACHINE_NAME $MODULE_DIR
  cd $MODULE_DIR

  $DCG entity:content \
    -a figma -a Figma -a Example -a example -a /example \
    -a No -a No -a No -a No -a No -a No -a No -a Yes -a No -a No -a No -a No -a No

  dcg_phpcs .
  dcg_module_install $MODULE_MACHINE_NAME
  # dcg_phpunit tests
  dcg_module_uninstall $MODULE_MACHINE_NAME
fi

# --- Test bundle class --- #
if [[ $DCG_TEST_FILTER = all || $DCG_TEST_FILTER = bundle_class ]]; then
  dcg_label 'Bundle classes'

  MODULE_MACHINE_NAME=acme
  MODULE_DIR=$DRUPAL_DIR/modules/$MODULE_MACHINE_NAME
  cp -R $SOURCE_DIR/$MODULE_MACHINE_NAME $MODULE_DIR
  cd $MODULE_DIR

  $DCG entity:bundle-class -a acme -a Acme -a Content -a All -a No

  # @todo fix tests.
  # dcg_phpcs $MODULE_DIR
  # dcg_module_install $MODULE_MACHINE_NAME
  # dcg_phpunit tests
  # dcg_module_uninstall $MODULE_MACHINE_NAME
fi

# --- Test module --- #
if [[ $DCG_TEST_FILTER = all || $DCG_TEST_FILTER = module ]]; then
  dcg_label Module

  MODULE_MACHINE_NAME=peach
  MODULE_DIR=$DRUPAL_DIR/modules/$MODULE_MACHINE_NAME
  cp -R $SOURCE_DIR/$MODULE_MACHINE_NAME $MODULE_DIR
  cd $MODULE_DIR

  $DCG module -d $DRUPAL_DIR/modules -a Peach -a peach -a 'Simple module generated by DCG.' \
    -a DCG -a 'drupal:views, drupal:node, drupal:action' -a Yes -a Yes -a Yes

  dcg_phpcs $MODULE_DIR
  dcg_module_install $MODULE_MACHINE_NAME
  dcg_phpunit tests
  dcg_module_uninstall $MODULE_MACHINE_NAME
fi

# --- Test theme --- #
if [[ $DCG_TEST_FILTER = all || $DCG_TEST_FILTER = theme ]]; then
  dcg_label Theme

  MODULE_MACHINE_NAME=tandoor
  MODULE_DIR=$DRUPAL_DIR/modules/$MODULE_MACHINE_NAME

  cp -r $SOURCE_DIR/$MODULE_MACHINE_NAME $MODULE_DIR
  cd $MODULE_DIR

  THEME_MACHINE_NAME=azalea
  THEME_DIR=$DRUPAL_DIR/themes/$THEME_MACHINE_NAME

  $DCG theme -d $DRUPAL_DIR/themes -a Azalea -a azalea -a claro -a 'Simple responsive theme generated by DCG.' \
    -a DCG -a Yes -a Yes

  dcg_phpcs $THEME_DIR
  dcg_phpcs $MODULE_DIR
  dcg_module_install $MODULE_MACHINE_NAME
  dcg_phpunit tests
  dcg_module_uninstall $MODULE_MACHINE_NAME
fi
