#!/usr/bin/env bash

# === Configuration. === #
set -e

function dcg_on_exit {
  local STATUS=$?
  $DRUPAL_DIR/vendor/bin/web.server stop
  if [ $STATUS -eq 0 ] ; then
    echo -e "\n\e[0;42m SUCCESS \e[0m"
  else
    echo -e "\n\e[0;41m FAIL \e[0m"
  fi
}
trap dcg_on_exit EXIT

SELF_PATH=$(dirname $0)/../tests/sut
if [ -z $DRUPAL_VERSION ]; then
  DRUPAL_VERSION=$(git ls-remote -h https://git.drupal.org/project/drupal.git | grep -o '8\..\.x' | tail -n1)'-dev'
fi
DRUPAL_DIR=${DRUPAL_DIR:-/tmp/dcg_sut}
DRUPAL_CACHED_DIR=${DRUPAL_CACHED_DIR:-/tmp/dcg_sut_cached/$DRUPAL_VERSION}
DRUPAL_HOST=${DRUPAL_HOST:-127.0.0.1}
DRUPAL_PORT=${DRUPAL_PORT:-8085}
DEFAULT_DCG=$(realpath $(dirname $0)/../bin/dcg)
DCG=${DCG:-$DEFAULT_DCG}
WD_URL=${WD_URL:-http://localhost:4444/wd/hub}
TARGET_TEST=${1:-all}

echo -----------------------------------------------
echo ' DRUPAL PATH:   ' $DRUPAL_DIR
echo ' DRUPAL VERSION:' $DRUPAL_VERSION
echo ' SITE URL:      ' http://$DRUPAL_HOST:$DRUPAL_PORT
echo ' DCG:           ' $DCG
echo ' WD_URL:        ' $WD_URL
echo -----------------------------------------------

# === Helper functions. === #

function dcg_drush {
  $DRUPAL_DIR/vendor/bin/drush -r $DRUPAL_DIR -y $@
}

function dcg_phpcs {
  $DRUPAL_DIR/vendor/bin/phpcs -p --standard=Drupal,DrupalPractice $@
}

function dcg_phpunit {
  SIMPLETEST_BASE_URL=http://$DRUPAL_HOST:$DRUPAL_PORT \
  SIMPLETEST_DB=sqlite://localhost//dev/shm/dcg_test.sqlite \
  MINK_DRIVER_ARGS_WEBDRIVER='["chrome", null, "'$WD_URL'"]' \
  $DRUPAL_DIR/vendor/bin/phpunit \
  -c $DRUPAL_DIR/core \
  $@
}

function dcg_label {
  echo -e "\n\e[30;43m -= $@ =- \e[0m\n"
}

# === Create a site under testing. === #

# Keep Drupal dir itself because PHP built-in server is watching it.
if [ -d $DRUPAL_DIR ]; then
  sudo rm -rf $DRUPAL_DIR/* $DRUPAL_DIR/.[^.]*
else
  mkdir -p $DRUPAL_DIR
fi

if [ -d $DRUPAL_CACHED_DIR ]; then
  cp -r $DRUPAL_CACHED_DIR/* $DRUPAL_DIR
else
  export COMPOSER_PROCESS_TIMEOUT=1900
  composer -d$DRUPAL_DIR -n create-project drupal/drupal $DRUPAL_DIR $DRUPAL_VERSION
  composer -d$DRUPAL_DIR require drush/drush chi-teck/web-server chi-teck/test-base
  composer -d$DRUPAL_DIR update squizlabs/php_codesniffer drupal/coder
  $DRUPAL_DIR/vendor/bin/phpcs --config-set installed_paths $DRUPAL_DIR/vendor/drupal/coder/coder_sniffer
  composer -d$DRUPAL_DIR run-script drupal-phpunit-upgrade
  cp -R $SELF_PATH/example $DRUPAL_DIR/modules
  mkdir -m 777 $DRUPAL_DIR/sites/default/files
  dcg_drush si minimal --db-url=sqlite://sites/default/files/.db.sqlite --sites-subdir=default
  mkdir -p $DRUPAL_CACHED_DIR
  cp -r $DRUPAL_DIR/. $DRUPAL_CACHED_DIR
fi

# Start server.
# Use Drush router because PHP built-in server cannot handle routers with dots.
# See https://bugs.php.net/bug.php?id=61286.
$DRUPAL_DIR/vendor/bin/web.server \
  start \
  $DRUPAL_HOST:$DRUPAL_PORT \
  --docroot=$DRUPAL_DIR \
  --router=$DRUPAL_DIR/vendor/drush/drush/misc/d8-rs-router.php
# === Tests === #

# --- Test forms --- #
if [ $TARGET_TEST = all -o $TARGET_TEST = form ]; then
  dcg_label Form

  MODULE_MACHINE_NAME=foo
  MODULE_DIR=$DRUPAL_DIR/modules/$MODULE_MACHINE_NAME

  cp -R $SELF_PATH/$MODULE_MACHINE_NAME $MODULE_DIR

  $DCG form:simple -d $MODULE_DIR -a Foo -a foo -a SimpleForm -a Yes -a foo.simple_form -a /admin/config/foo/simple -a Example -a 'access administration pages'
  $DCG form:config -d $MODULE_DIR -a Foo -a foo -a SettingsForm -a Yes -a foo.config_form -a /admin/config/foo/settings -a Example -a 'access administration pages' -a No
  $DCG form:confirm -d $MODULE_DIR -a Foo -a foo -a ConfirmForm -a Yes -a foo.confirm_form -a /admin/config/foo/confirm -a Example -a 'access administration pages'

  dcg_phpcs --exclude=DrupalPractice.Yaml.RoutingAccess $MODULE_DIR
  dcg_drush en $MODULE_MACHINE_NAME
  dcg_phpunit $MODULE_DIR/tests
  dcg_drush pmu $MODULE_MACHINE_NAME
fi

# --- Test module components --- #
if [ $TARGET_TEST = all -o $TARGET_TEST = module_component ]; then
  dcg_label Module component

  MODULE_MACHINE_NAME=bar
  MODULE_DIR=$DRUPAL_DIR/modules/$MODULE_MACHINE_NAME

  cp -R $SELF_PATH/$MODULE_MACHINE_NAME $MODULE_DIR

  $DCG composer -d $MODULE_DIR -a bar -a 'Bar project' -a 'drupal-module' -a Yes
  $DCG controller -d $MODULE_DIR -a Bar -a bar -a BarController -a No -a Yes -a bar.example -a /bar/example -a Example -a 'access content'
  $DCG install -d $MODULE_DIR -a Bar -a bar
  $DCG javascript -d $MODULE_DIR -a Bar -a bar
  $DCG module-file -d $MODULE_DIR -a Bar -a bar
  $DCG service-provider -d $MODULE_DIR  -a Bar -a bar
  $DCG template -d $MODULE_DIR -a Bar -a bar -a example -a Yes -a Yes
  $DCG layout -d $MODULE_DIR -a bar -a Foo -a foo -a my -a Yes -a Yes

  $DCG render-element -d $MODULE_DIR -a bar

  $DCG field -d $MODULE_DIR \
    -a Bar -a bar -a 'Example 1' -a bar_example_1 -a 10 \
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

  $DCG field -d $MODULE_DIR \
    -a Bar -a bar -a 'Example 2' -a bar_example_2 -a 10 \
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

  $DCG field -d $MODULE_DIR \
    -a Bar -a bar -a 'Example 3' -a bar_example_3 -a 5 \
    -a 'Value 1' -a value_1 -a Boolean -a No \
    -a 'Value 2' -a value_2 -a Text -a No -a No \
    -a 'Value 3' -a value_3 -a 'Text (long)' -a No \
    -a 'Value 4' -a value_4 -a Email -a No -a No \
    -a 'Value 5' -a value_5 -a Url -a No -a No \
    -a Yes -a Yes -a Yes -a Yes -a Yes -a Yes

  dcg_phpcs $MODULE_DIR
  dcg_drush en $MODULE_MACHINE_NAME
  dcg_phpunit $MODULE_DIR/tests
  dcg_drush pmu $MODULE_MACHINE_NAME
fi

# --- Test plugins --- #
if [ $TARGET_TEST = all -o $TARGET_TEST = plugin ]; then
  dcg_label Plugin

  MODULE_MACHINE_NAME=qux
  MODULE_DIR=$DRUPAL_DIR/modules/$MODULE_MACHINE_NAME

  cp -R $SELF_PATH/$MODULE_MACHINE_NAME $MODULE_DIR

  $DCG plugin:field:formatter -d $MODULE_DIR -a Qux -a qux -a Example -a qux_example -a ExampleFormatter -a Yes
  $DCG plugin:field:type -d $MODULE_DIR -a Qux -a qux -a Example -a qux_example -a ExampleItem -a Yes -a Yes
  $DCG plugin:field:widget -d $MODULE_DIR -a Qux -a qux -a Example -a qux_example -a ExampleWidget -a Yes

  $DCG plugin:migrate:process -d $MODULE_DIR -a Qux -a qux -a example -a Example

  $DCG plugin:views:argument-default -d $MODULE_DIR -a Qux -a qux -a Example -a qux_example -a Example -a Yes -a No
  $DCG plugin:views:field -d $MODULE_DIR -a Qux -a qux -a Example -a qux_example -a Example -a Yes -a No
  $DCG plugin:views:style -d $MODULE_DIR -a Qux -a qux -a Example -a qux_example -a Example -a Yes -a No

  $DCG plugin:action -d $MODULE_DIR -a Qux -a qux -a 'Update node title' -a qux_update_node_title -a UpdateNodeTitle -a DCG -a Yes
  $DCG plugin:block -d $MODULE_DIR -a Qux -a qux -a Example -a example -a ExampleBlock -a DCG -a Yes -a No -a No
  $DCG plugin:ckeditor -d $MODULE_DIR -a Qux -a qux -a Example -a qux_example -a Example
  $DCG plugin:condition -d $MODULE_DIR -a Qux -a qux -a Example -a example -a Example
  $DCG plugin:entity-reference-selection -d $MODULE_DIR -a Qux -a qux -a node -a Example -a qux_example -a Example -a Yes
  $DCG plugin:filter -d $MODULE_DIR -a Qux -a qux -a Example -a example -a Example -a 'HTML restrictor'
  $DCG plugin:menu-link -d $MODULE_DIR -a Qux -a qux -a FooExampleLink
  $DCG plugin:queue-worker -d $MODULE_DIR -a Qux -a qux -a Example -a qux_example -a Example
  $DCG plugin:rest-resource -d $MODULE_DIR -a Qux -a qux -a Example -a qux_example -a ExampleResource

  dcg_phpcs $MODULE_DIR
  dcg_drush en $MODULE_MACHINE_NAME
  dcg_phpunit $MODULE_DIR/tests
  dcg_drush pmu $MODULE_MACHINE_NAME
fi

# --- Test services --- #
if [ $TARGET_TEST = all -o $TARGET_TEST = service ]; then
  dcg_label Service

  MODULE_MACHINE_NAME=zippo
  MODULE_DIR=$DRUPAL_DIR/modules/$MODULE_MACHINE_NAME

  cp -R $SELF_PATH/$MODULE_MACHINE_NAME $MODULE_DIR

  $DCG service:access-checker -d $MODULE_DIR -a Zippo -a zippo -a _zippo -a ZippoAccessChecker
  $DCG service:breadcrumb-builder -d $MODULE_DIR -a Zippo -a zippo -a ZippoBreadcrumbBuilder
  $DCG service:custom -d $MODULE_DIR -a Zippo -a zippo -a zippo.foo -a Foo -a Y -a entity_type.manager -a
  $DCG service:event-subscriber -d $MODULE_DIR -a Zippo -a zippo
  $DCG service:logger -d $MODULE_DIR -a Zippo -a zippo -a FileLog
  $DCG service:middleware -d $MODULE_DIR -a Zippo -a zippo
  $DCG service:param-converter -d $MODULE_DIR -a Zippo -a zippo -a example -a ExampleParamConverter
  $DCG service:route-subscriber -d $MODULE_DIR -a Zippo -a zippo
  $DCG service:theme-negotiator -d $MODULE_DIR -a Zippo -a zippo -a ZippoThemeNegotiator
  $DCG service:twig-extension -d $MODULE_DIR -a Zippo -a zippo -a ZippoTwigExtension -a No
  $DCG service:path-processor -d $MODULE_DIR -a Zippo -a zippo -a PathProcessorZippo
  $DCG service:request-policy -d $MODULE_DIR -a Zippo -a zippo -a Example
  $DCG service:response-policy -d $MODULE_DIR -a Zippo -a zippo -a ExampleResponsePolicy
  $DCG service:uninstall-validator -d $MODULE_DIR -a Zippo -a zippo -a ExampleUninstallValidator
  $DCG service:cache-context -d $MODULE_DIR -a Zippo -a zippo -a example -a ExampleCacheContext -a UserCacheContextBase -a Yes

  dcg_phpcs $MODULE_DIR
  dcg_drush en $MODULE_MACHINE_NAME
  dcg_phpunit $MODULE_DIR/tests
  dcg_drush pmu $MODULE_MACHINE_NAME
fi

# --- Test YML --- #
if [ $TARGET_TEST = all -o $TARGET_TEST = yml ]; then
  dcg_label YML

  MODULE_MACHINE_NAME=yety
  MODULE_DIR=$DRUPAL_DIR/modules/$MODULE_MACHINE_NAME

  cp -R $SELF_PATH/$MODULE_MACHINE_NAME $MODULE_DIR

  $DCG yml:links:action -d $MODULE_DIR -a yety
  $DCG yml:links:contextual -d $MODULE_DIR -a yety
  $DCG yml:links:menu -d $MODULE_DIR -a yety
  $DCG yml:links:task -d $MODULE_DIR -a yet
  $DCG yml:module-info -d $MODULE_DIR -a Yety -a yety -a 'Helper module for testing generated YML files' -a DCG -a -a drupal:system,drupal:node,drupal:user
  $DCG yml:module-libraries -d $MODULE_DIR -a yety
  $DCG yml:permissions -d $MODULE_DIR -a yety
  $DCG yml:routing -d $MODULE_DIR -a Yety -a yety
  $DCG yml:services -d $MODULE_DIR -a Yety -a yety

  dcg_phpcs $MODULE_DIR
  dcg_drush en $MODULE_MACHINE_NAME
#  dcg_phpunit $MODULE_DIR/tests
  dcg_drush pmu $MODULE_MACHINE_NAME
fi

# --- Test tests --- #
if [ $TARGET_TEST = all -o $TARGET_TEST = test ]; then
  dcg_label Test

  MODULE_MACHINE_NAME=xerox
  MODULE_DIR=$DRUPAL_DIR/modules/$MODULE_MACHINE_NAME

  cp -R $SELF_PATH/$MODULE_MACHINE_NAME $MODULE_DIR

  $DCG test:browser -d $MODULE_DIR -a Xerox -a xerox -a ExampleTest
  $DCG test:webdriver -d $MODULE_DIR -a Xerox -a xerox -a ExampleTest
  $DCG test:kernel -d $MODULE_DIR -a Xerox -a xerox -a ExampleTest
  $DCG test:unit -d $MODULE_DIR -a Xerox -a xerox -a ExampleTest

  dcg_phpcs --exclude=Generic.CodeAnalysis.UselessOverridingMethod $MODULE_DIR
  dcg_drush en $MODULE_MACHINE_NAME
  dcg_phpunit $MODULE_DIR/tests
  dcg_drush pmu $MODULE_MACHINE_NAME
fi

# --- Test theme components --- #
if [ $TARGET_TEST = all -o $TARGET_TEST = theme_component ]; then
  dcg_label Theme component

  THEME_MACHINE_NAME=shreya
  THEME_DIR=$DRUPAL_DIR/themes/$THEME_MACHINE_NAME

  mkdir $THEME_DIR

  $DCG theme-file -d $THEME_DIR -a Shreya -a shreya
  $DCG yml:breakpoints -d $THEME_DIR -a shreya
  $DCG theme-settings -d $THEME_DIR -a Shreya -a shreya
  $DCG yml:theme-libraries -d $THEME_DIR -a shreya
  $DCG yml:theme-info -d $THEME_DIR -a Shreya -a shreya -a bartik -a 'Helper theme for testing DCG components.' -a DCG

  dcg_phpcs $THEME_DIR
fi

# --- Test plugin manager --- #
if [ $TARGET_TEST = all -o $TARGET_TEST = plugin_manager ]; then
  dcg_label Plugin manager

  MODULE_MACHINE_NAME=lamda
  MODULE_DIR=$DRUPAL_DIR/modules/$MODULE_MACHINE_NAME
  cp -R $SELF_PATH/$MODULE_MACHINE_NAME $MODULE_DIR

  $DCG plugin-manager -d $MODULE_DIR -a Lamda -a lamda -a alpha -a Annotation
  $DCG plugin-manager -d $MODULE_DIR -a Lamda -a lamda -a beta -a YAML
  $DCG plugin-manager -d $MODULE_DIR -a Lamda -a lamda -a gamma -a Hook

  dcg_phpcs $MODULE_DIR
  dcg_drush en $MODULE_MACHINE_NAME
  dcg_phpunit $MODULE_DIR/tests
  dcg_drush pmu $MODULE_MACHINE_NAME
fi

# --- Test configuration entity --- #
if [ $TARGET_TEST = all -o $TARGET_TEST = configuration_entity ]; then
  dcg_label Configuration entity

  MODULE_MACHINE_NAME=wine
  MODULE_DIR=$DRUPAL_DIR/modules/$MODULE_MACHINE_NAME

  $DCG module:configuration-entity -d $DRUPAL_DIR/modules -a Wine -a wine -a DCG -a drupal:user -a Example -a example
  cp -R $SELF_PATH/$MODULE_MACHINE_NAME/* $MODULE_DIR

  dcg_phpcs $MODULE_DIR
  dcg_drush en $MODULE_MACHINE_NAME
  dcg_phpunit $MODULE_DIR/tests
  dcg_drush pmu $MODULE_MACHINE_NAME
fi

# --- Test content entity --- #
if [ $TARGET_TEST = all -o $TARGET_TEST = content_entity ]; then
  dcg_label 'Content entity (full)'

  MODULE_MACHINE_NAME=nigma
  MODULE_DIR=$DRUPAL_DIR/modules/$MODULE_MACHINE_NAME

  $DCG module:content-entity -d $DRUPAL_DIR/modules \
    -a Nigma -a nigma -a DCG -a drupal:user -a Example -a example -a /admin/content/example \
    -a Yes -a Yes -a Yes -a Yes -a Yes -a Yes -a Yes -a Yes -a Yes -a Yes -a Yes -a Yes -a Yes

  cp -R $SELF_PATH/$MODULE_MACHINE_NAME/* $MODULE_DIR

  dcg_phpcs $MODULE_DIR
  dcg_drush en $MODULE_MACHINE_NAME
  dcg_phpunit $MODULE_DIR/tests
  dcg_drush pmu $MODULE_MACHINE_NAME

  dcg_label 'Content entity (light)'

  MODULE_MACHINE_NAME=sigma
  MODULE_DIR=$DRUPAL_DIR/modules/$MODULE_MACHINE_NAME

  $DCG module:content-entity -d $DRUPAL_DIR/modules \
    -a Sigma -a sigma -a DCG -a drupal:system -a Example -a example -a /example \
    -a Yes -a No -a No -a No -a No -a No -a Yes -a No -a No -a No -a No -a No -a No

  cp -R $SELF_PATH/$MODULE_MACHINE_NAME/* $MODULE_DIR

  dcg_phpcs $MODULE_DIR
  dcg_drush en $MODULE_MACHINE_NAME
  dcg_phpunit $MODULE_DIR/tests
  dcg_drush pmu $MODULE_MACHINE_NAME
fi

# --- Test module --- #
if [ $TARGET_TEST = all -o $TARGET_TEST = module ]; then
  dcg_label Simple module

  MODULE_MACHINE_NAME=peach
  MODULE_DIR=$DRUPAL_DIR/modules/$MODULE_MACHINE_NAME

  $DCG module:standard -d $DRUPAL_DIR/modules -a Peach -a peach -a 'Simple module generated by DCG.' \
    -a DCG -a 'drupal:views, drupal:node, drupal:action' -a Yes -a Yes -a Yes -a Yes -a Yes -a Yes -a Yes -a Yes

  dcg_phpcs $MODULE_DIR
  dcg_drush en $MODULE_MACHINE_NAME
  #dcg_phpunit $MODULE_PATH/tests
  dcg_drush pmu $MODULE_MACHINE_NAME
fi

# --- Test theme --- #
if [ $TARGET_TEST = all -o $TARGET_TEST = theme ]; then
  dcg_label Theme

  THEME_MACHINE_NAME=azalea
  THEME_DIR=$DRUPAL_DIR/themes/$THEME_MACHINE_NAME

  $DCG theme -d $DRUPAL_DIR/themes -a Azalea -a azalea -a bartik -a 'Simple responsive theme generated by DCG.' \
    -a DCG -a Yes -a Yes -a Yes

  # Code sniffer does not like empty files.
  dcg_phpcs --ignore='\.css' $THEME_DIR
fi
