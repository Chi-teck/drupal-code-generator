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
DRUPAL_VERSION=${DRUPAL_VERSION:-8.7.x-dev}
DRUPAL_DIR=${DRUPAL_DIR:-/tmp/dcg_sut}
DRUPAL_CACHED_DIR=${DRUPAL_CACHED_DIR:-/tmp/dcg_sut_cached/$DRUPAL_VERSION}
DRUPAL_HOST=${DRUPAL_HOST:-127.0.0.1}
DRUPAL_PORT=${DRUPAL_PORT:-8085}
DEFAULT_DCG=$(realpath $(dirname $0)/../bin/dcg)
DCG=${DCG:-$DEFAULT_DCG}
WD_URL=${WD_URL:-http://localhost:4444/wd/hub}
TARGET_TEST=${1:-all}

echo ---------------------------------------------
echo ' DRUPAL PATH:   ' $DRUPAL_DIR
echo ' DRUPAL VERSION:' $DRUPAL_VERSION
echo ' SITE URL:      ' http://$DRUPAL_HOST:$DRUPAL_PORT
echo ' DCG:           ' $DCG
echo ' WD_URL:        ' $WD_URL
echo ---------------------------------------------

# === Helper functions. === #

function dcg_drush {
  $DRUPAL_DIR/vendor/bin/drush -r $DRUPAL_DIR -y $@
}

function dcg_phpcs {
  $DRUPAL_DIR/vendor/bin/phpcs -p --standard=Drupal,DrupalPractice $@
}

function dcg_phpunit {
  SIMPLETEST_BASE_URL=http://$DRUPAL_HOST:$DRUPAL_PORT \
  SIMPLETEST_DB=sqlite://tmp/test.sqlite \
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
  composer -d$DRUPAL_DIR update squizlabs/php_codesniffer
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

  $DCG d8:form:simple -d $MODULE_DIR -a '{"name":"Foo","machine_name":"foo","class":"SimpleForm","route":"Yes","route_name":"foo_simple_form","route_path":"/admin/config/foo/simple","route_title":"Example","route_permission":"access administration pages"}'
  $DCG d8:form:config -d $MODULE_DIR -a '{"name":"Foo","machine_name":"foo","class":"SettingsForm","route":"Yes","route_name":"foo_config_form","route_path":"/admin/config/foo/settings","route_title":"Example","route_permission":"access administration pages"}'
  $DCG d8:form:confirm -d $MODULE_DIR -a '{"name":"Foo","machine_name":"foo","class":"ConfirmForm","route":"Yes","route_name":"foo_confirm_form","route_path":"/admin/config/foo/confirm","route_title":"Example","route_permission":"access administration pages"}'

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

  $DCG d8:composer -d $MODULE_DIR -a '{"machine_name":"bar","description":"Bar project.","type":"drupal-module","drupal_org":"Yes"}'
  $DCG d8:controller -d $MODULE_DIR -a '{"name":"Bar","machine_name":"bar","class":"BarController","di":"No","route":true,"route_name":"bar.example","route_path":"/bar/example","route_title":"Example","route_permission":"access content"}'
  $DCG d8:install -d $MODULE_DIR -a '{"name":"Bar","machine_name":"bar"}'
  $DCG d8:javascript -d $MODULE_DIR -a '{"name":"Bar","machine_name":"bar"}'
  $DCG d8:module-file -d $MODULE_DIR -a '{"name":"Bar","machine_name":"bar"}'
  $DCG d8:service-provider -d $MODULE_DIR  -a '{"name":"Bar","machine_name":"bar"}'
  $DCG d8:template -d $MODULE_DIR -a '{"name":"Bar","machine_name":"bar","template_name":"example","create_theme":"Yes","create_preprocess":"Yes"}'
  $DCG d8:layout -d $MODULE_DIR -a '{"machine_name":"bar","layout_name":"Foo","layout_machine_name":"foo","category":"my","js":"Yes","css":"Yes"}'
  $DCG d8:render-element -d $MODULE_DIR -a '{"machine_name":"bar"}'

  $DCG d8:field -d $MODULE_DIR -a '{"machine_name":"bar","field_label":"Example 1","subfield_count":"10","type_1":"Boolean","type_2":"Text","type_3":"Text (long)","type_4":"Integer","type_5":"Float","type_6":"Numeric","type_7":"Email","type_8":"Telephone","type_9":"Url","type_10":"Date"}'
  $DCG d8:field -d $MODULE_DIR -a '{"machine_name":"bar","field_label":"Example 2","subfield_count":"10","type_1":"Boolean","required_1":"Yes","type_2":"Text","list_2":"Yes","required_2":"Yes","type_3":"Text (long)","required_3":"Yes","type_4":"Integer","list_4":"Yes","type_5":"Float","list_5":"Yes","required_5":"Yes","type_6":"Numeric","list_6":"Yes","type_7":"Email","list_7":"Yes","required_7":"Yes","type_8":"Telephone","list_8":"Yes","type_9":"Url","list_9":"Yes","required_9":"Yes","type_10":"Date","list_10":"Yes","date_type_10":"Date and time"}'
  $DCG d8:field -d $MODULE_DIR -a '{"machine_name":"bar","field_label":"Example 3","subfield_count":"5","type_1":"Boolean","type_2":"Text","type_3":"Text (long)","type_4":"Email","type_5":"Url","storage_settings":"Yes","instance_settings":"Yes","widget_settings":"Yes","formatter_settings":"Yes","table_formatter":"Yes","key_value_formatter":"Yes"}'

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

  $DCG d8:plugin:field:formatter -d $MODULE_DIR -a '{"name":"Qux","machine_name":"qux","plugin_label":"Example","plugin_id":"qux_example","configurable":"Yes"}'
  $DCG d8:plugin:field:type -d $MODULE_DIR -a '{"name":"Qux","machine_name":"qux","plugin_label":"Example","plugin_id":"qux_example","configurable_storage":"Yes","configurable_instance":"Yes"}'
  $DCG d8:plugin:field:widget -d $MODULE_DIR -a '{"name":"Qux","machine_name":"qux","plugin_label":"Example","plugin_id":"qux_example","configurable":"Yes"}'

  $DCG d8:plugin:migrate:process -d $MODULE_DIR -a '{"name":"Qux","machine_name":"qux","plugin_id":"example"}'

  $DCG d8:plugin:views:argument-default -d $MODULE_DIR -a '{"name":"Qux","machine_name":"qux","plugin_label":"Example","plugin_id":"qux_example"}'
  $DCG d8:plugin:views:field -d $MODULE_DIR -a '{"name":"Qux","machine_name":"qux","plugin_label":"Example","plugin_id":"qux_example"}'
  $DCG d8:plugin:views:style -d $MODULE_DIR -a '{"name":"Qux","machine_name":"qux","plugin_label":"Example","plugin_id":"qux_example"}'

  $DCG d8:plugin:action -d $MODULE_DIR -a '{"name":"Qux","machine_name":"qux","plugin_label":"Update node title","plugin_id":"qux_update_node_title","category":"DCG","configurable":true}'
  $DCG d8:plugin:block -d $MODULE_DIR -a '{"name":"Qux","machine_name":"qux","plugin_label":"Example","plugin_id":"example","category":"DCG", "configurable":"Yes","di":"Yes","access":"Yes"}'
  $DCG d8:plugin:condition -d $MODULE_DIR -a '{"name":"Qux","machine_name":"qux","plugin_label":"Example","plugin_id":"example"}'
  $DCG d8:plugin:filter -d $MODULE_DIR -a '{"name":"Qux","machine_name":"qux","plugin_label":"Example","plugin_id":"example", "filter_type":"HTML restrictor"}'
  $DCG d8:plugin:menu-link -d $MODULE_DIR -a '{"name":"Qux","machine_name":"qux","class":"FooExampleLink"}'
  $DCG d8:plugin:rest-resource -d $MODULE_DIR -a '{"name":"Qux","machine_name":"qux","plugin_label":"Example","plugin_id":"qux_example"}'
  $DCG d8:plugin:entity-reference-selection -d $MODULE_DIR -a '{"name":"Qux","machine_name":"qux","entity_type":"node","plugin_label":"Example","plugin_id":"qux_example","configurable":"Yes","class":"ExampleNodeSelection"}'

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

  $DCG d8:service:access-checker -d $MODULE_DIR -a '{"name":"Zippo","machine_name":"zippo","applies_to":"_zippo","class":"ZippoAccessChecker"}'
  $DCG d8:service:breadcrumb-builder -d $MODULE_DIR -a '{"name":"Zippo","machine_name":"zippo","class":"ZippoBreadcrumbBuilder"}'
  $DCG d8:service:custom -d $MODULE_DIR -a '{"name":"Zippo","machine_name":"zippo", "service_name":"zippo.foo","class":"Foo","di":"Yes"}'
  $DCG d8:service:event-subscriber -d $MODULE_DIR -a '{"name":"Zippo","machine_name":"zippo"}'
  $DCG d8:service:logger -d $MODULE_DIR -a '{"name":"Zippo","machine_name":"zippo","class":"FileLog"}'
  $DCG d8:service:middleware -d $MODULE_DIR -a '{"name":"Dcg service","machine_name":"zippo"}'
  $DCG d8:service:param-converter -d $MODULE_DIR -a '{"name":"Zippo","machine_name":"zippo","parameter_type":"example","class":"ExampleParamConverter"}'
  $DCG d8:service:route-subscriber -d $MODULE_DIR -a '{"name":"Zippo","machine_name":"zippo"}'
  $DCG d8:service:theme-negotiator -d $MODULE_DIR -a '{"name":"Zippo","machine_name":"zippo","class":"ZippoThemeNegotiator"}'
  $DCG d8:service:twig-extension -d $MODULE_DIR -a '{"name":"Zippo","machine_name":"zippo","class":"ZippoTwigExtension","di":"Yes"}'
  $DCG d8:service:path-processor -d $MODULE_DIR -a '{"name":"Zippo","machine_name":"zippo","class":"PathProcessorZippo"}'
  $DCG d8:service:request-policy -d $MODULE_DIR -a '{"name":"Zippo","machine_name":"zippo","class":"Example"}'
  $DCG d8:service:response-policy -d $MODULE_DIR -a '{"name":"Zippo","machine_name":"zippo","class":"ExampleResponsePolicy"}'
  $DCG d8:service:uninstall-validator -d $MODULE_DIR -a '{"name":"Zippo","machine_name":"zippo","class":"ExampleUninstallValidator"}'
  $DCG d8:service:cache-context -d $MODULE_DIR -a '{"name":"Zippo","machine_name":"zippo","class":"ExampleCacheContext"}'

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

  $DCG d8:yml:links:action -d $MODULE_DIR -a '{"machine_name":"yety"}'
  $DCG d8:yml:links:contextual -d $MODULE_DIR -a '{"machine_name":"yety"}'
  $DCG d8:yml:links:menu -d $MODULE_DIR -a '{"machine_name":"yety"}'
  $DCG d8:yml:links:task -d $MODULE_DIR -a '{"machine_name":"yety"}'
  $DCG d8:yml:module-info -d $MODULE_DIR -a '{"name":"Yety","machine_name":"yety","description":"Helper module for testing generated YML files.", "package": "DCG","configure":"", "dependencies":""}'
  $DCG d8:yml:module-libraries -d $MODULE_DIR -a '{"name":"Yety","machine_name":"yety"}'
  $DCG d8:yml:permissions -d $MODULE_DIR -a '{"machine_name":"yety"}'
  $DCG d8:yml:routing -d $MODULE_DIR -a '{"name":"Yety","machine_name":"yety"}'
  $DCG d8:yml:services -d $MODULE_DIR -a '{"name":"Yety","machine_name":"yety"}'

  dcg_phpcs $MODULE_DIR
  dcg_drush en $MODULE_MACHINE_NAME
  #dcg_phpunit $MODULE_PATH/tests
  dcg_drush pmu $MODULE_MACHINE_NAME
fi

# --- Test tests --- #
if [ $TARGET_TEST = all -o $TARGET_TEST = test ]; then
  dcg_label Test

  MODULE_MACHINE_NAME=xerox
  MODULE_DIR=$DRUPAL_DIR/modules/$MODULE_MACHINE_NAME

  cp -R $SELF_PATH/$MODULE_MACHINE_NAME $MODULE_DIR

  $DCG d8:test:browser -d $MODULE_DIR -a '{"name":"Xerox", "machine_name":"xerox","class":"ExampleTest"}'
  $DCG d8:test:webdriver -d $MODULE_DIR -a '{"name":"Xerox", "machine_name":"xerox","class":"ExampleTest"}'
  $DCG d8:test:kernel -d $MODULE_DIR -a '{"name":"Xerox", "machine_name":"xerox","class":"ExampleTest"}'
  $DCG d8:test:unit -d $MODULE_DIR -a '{"name":"Xerox", "machine_name":"xerox","class":"ExampleTest"}'
  $DCG d8:test:web -d $MODULE_DIR -a '{"name":"Xerox", "machine_name":"xerox","class":"ExampleTest"}'

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

  $DCG d8:theme-file -d $MODULE_DIR -a '{"name":"Shreya","machine_name":"shreya"}'
  $DCG d8:yml:breakpoints -d $MODULE_DIR -a '{"machine_name":"shreya"}'
  $DCG d8:theme-settings -d $MODULE_DIR -a '{"name":"Shreya","machine_name":"shreya"}'
  $DCG d8:yml:theme-libraries -d $MODULE_DIR -a '{"machine_name":"shreya"}'
  $DCG d8:yml:theme-info -d $MODULE_DIR -a '{"name":"Shreya","machine_name":"shreya","base_theme":"bartik","description":"Helper theme for testing DCG components.","package":"DCG"}'

  dcg_phpcs $THEME_DIR
fi

# --- Test plugin manager --- #
if [ $TARGET_TEST = all -o $TARGET_TEST = plugin_manager ]; then
  dcg_label Plugin manager

  MODULE_MACHINE_NAME=lamda
  MODULE_DIR=$DRUPAL_DIR/modules/$MODULE_MACHINE_NAME
  cp -R $SELF_PATH/$MODULE_MACHINE_NAME $MODULE_DIR

  $DCG d8:plugin-manager -d $MODULE_DIR -a '{"name":"Lamda","machine_name":"lamda","plugin_type":"alpha","discovery":"Annotation"}'
  $DCG d8:plugin-manager -d $MODULE_DIR -a '{"name":"Lamda","machine_name":"lamda","plugin_type":"beta","discovery":"YAML"}'
  $DCG d8:plugin-manager -d $MODULE_DIR -a '{"name":"Lamda","machine_name":"lamda","plugin_type":"gamma","discovery":"Hook"}'

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

  $DCG d8:module:configuration-entity -d $DRUPAL_DIR/modules -a '{"name":"Wine","machine_name":"wine","description":"Configuration entity module generated by DCG.","entity_type_label":"Example","entity_type_id":"example","dependencies":"drupal:views","package":"DCG"}'
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

  $DCG d8:module:content-entity -d $DRUPAL_DIR/modules -a '{"name":"Nigma","machine_name":"nigma","description":"Content entity module generated by DCG.","entity_type_label":"Example","entity_type_id":"example","package":"DCG","entity_base_path":"/admin/content/example","fieldable":"Yes","revisionable":"Yes","translatable":"Yes","bundle":"Yes","template":"Yes","access_controller":"Yes","title_base_field":"Yes","status_base_field":"Yes","created_base_field":"Yes","changed_base_field":"Yes","author_base_field":"Yes","description_base_field":"Yes","rest_configuration":"Yes"}'
  cp -R $SELF_PATH/$MODULE_MACHINE_NAME/* $MODULE_DIR

  dcg_phpcs $MODULE_DIR
  dcg_drush en $MODULE_MACHINE_NAME
  dcg_phpunit $MODULE_DIR/tests
  dcg_drush pmu $MODULE_MACHINE_NAME

  dcg_label 'Content entity (light)'

  MODULE_MACHINE_NAME=sigma
  MODULE_DIR=$DRUPAL_DIR/modules/$MODULE_MACHINE_NAME

  $DCG d8:module:content-entity -d $DRUPAL_DIR/modules -a '{"name":"Sigma","machine_name":"sigma","description":"Content entity module generated by DCG.","entity_type_label":"Example","entity_type_id":"example","package":"DCG","entity_base_path":"/example","fieldable":"Yes","revisionable":"No","translatable":"No","bundle":"No","template":"No","access_controller":"No","title_base_field":"Yes","status_base_field":"No","created_base_field":"No","changed_base_field":"No","author_base_field":"No","description_base_field":"No","rest_configuration":"No"}'
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

  $DCG d8:module:standard -d $DRUPAL_DIR/modules -a '{"name":"Peach","machine_name":"peach","description":"Simple module generated by DCG.","dependencies":"drupal:views, drupal:node, drupal:action","package":"DCG","install_file":"Yes","libraries.yml":"Yes","permissions.yml":"Yes","event_subscriber":"Yes","block_plugin":"Yes","controller":"Yes","settings_form":"Yes"}'

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

  # Generate a theme.
  $DCG d8:theme -d $DRUPAL_DIR/themes -a '{"name":"Azalea","machine_name":"azalea","base_theme":"bartik","description":"Simple theme generated by DCG.","package":"DCG","sass":"Yes","breakpoints":"Yes","theme_settings":"Yes"}'

  # Code sniffer does not like empty files.
  dcg_phpcs --ignore='\.css' $THEME_DIR
fi
