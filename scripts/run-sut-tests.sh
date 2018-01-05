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
DRUPAL_VERSION=${DRUPAL_VERSION:-8.5.x-dev}
DRUPAL_DIR=${DRUPAL_DIR:-/tmp/dcg_sut}
DRUPAL_CACHED_DIR=${DRUPAL_CACHED_DIR:-/tmp/dcg_sut_cached/$DRUPAL_VERSION}
DRUPAL_HOST=${DRUPAL_HOST:-127.0.0.1}
DRUPAL_PORT=${DRUPAL_PORT:-8085}
DEFAULT_DCG=$(realpath $(dirname $0)/../bin/dcg)
DCG=${DCG:-$DEFAULT_DCG}
TARGET_TEST=${1:-all}

echo --------------------------------------
echo ' DRUPAL PATH:   ' $DRUPAL_DIR
echo ' DRUPAL VERSION:' $DRUPAL_VERSION
echo ' SITE URL:      ' http://$DRUPAL_HOST:$DRUPAL_PORT
echo ' DCG:           ' $DCG
echo --------------------------------------

# === Helper functions. === #

function dcg_drush {
  $DRUPAL_DIR/vendor/bin/drush -r $DRUPAL_DIR -y $@
}

function dcg_phpcs {
  $DRUPAL_DIR/vendor/bin/phpcs --standard=Drupal,DrupalPractice $@
}

function dcg_phpunit {
  SIMPLETEST_BASE_URL=http://$DRUPAL_HOST:$DRUPAL_PORT \
  SIMPLETEST_DB=sqlite://tmp/test.sqlite \
  $DRUPAL_DIR/vendor/bin/phpunit \
  -c $DRUPAL_DIR/core $@
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
  composer -d=$DRUPAL_DIR -n create-project drupal/drupal $DRUPAL_DIR $DRUPAL_VERSION
  composer -d=$DRUPAL_DIR require drush/drush:dev-master chi-teck/web-server chi-teck/test-base
  composer -d=$DRUPAL_DIR update squizlabs/php_codesniffer
  $DRUPAL_DIR/vendor/bin/phpcs --config-set installed_paths $DRUPAL_DIR/vendor/drupal/coder/coder_sniffer
  mkdir -m 777 $DRUPAL_DIR/sites/default/files
  dcg_drush si minimal --db-url=sqlite://sites/default/files/.db.sqlite
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

  $DCG d8:form:simple -d $MODULE_DIR -a '{"name":"Foo","machine_name":"foo","class":"SimpleForm","form_id":"foo_simple","route":"Yes","route_name":"foo_simple_form","route_path":"/admin/config/foo/simple","route_title":"example","route_permission":"access administration pages"}'
  $DCG d8:form:config -d $MODULE_DIR -a '{"name":"Foo","machine_name":"foo","class":"SettingsForm","form_id":"foo_config","route":"Yes","route_name":"foo_config_form","route_path":"/admin/config/foo/settings","route_title":"example","route_permission":"access administration pages"}'
  $DCG d8:form:confirm -d $MODULE_DIR -a '{"name":"Foo","machine_name":"foo","class":"ConfirmForm","form_id":"foo_confirm", "route":"Yes","route_name":"foo_confirm_form","route_path":"/admin/config/foo/confirm","route_title":"example","route_permission":"access administration pages"}'

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
  $DCG d8:controller -d $MODULE_DIR -a '{"name":"Bar","machine_name":"bar","class":"BarController","route":true,"route_name":"bar.example","route_path":"/bar/example","route_title":"Example","route_permission":"access content"}'
  $DCG d8:install -d $MODULE_DIR -a '{"name":"Bar","machine_name":"bar"}'
  $DCG d8:javascript -d $MODULE_DIR -a '{"name":"Bar","machine_name":"bar"}'
  $DCG d8:module-file -d $MODULE_DIR -a '{"name":"Bar","machine_name":"bar"}'
  $DCG d8:service-provider -d $MODULE_DIR  -a '{"name":"Bar","machine_name":"bar"}'
  $DCG d8:template -d $MODULE_DIR -a '{"name":"Bar","machine_name":"bar","template_name":"example","create_theme":"yes","create_preprocess":"yes"}'
  $DCG d8:layout -d $MODULE_DIR -a '{"machine_name":"bar","layout_name":"Foo","layout_machine_name":"foo","category":"my","js":"Yes","css":"Yes"}'

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

  $DCG d8:plugin:field:formatter -d $MODULE_DIR -a '{"name":"Qux","machine_name":"qux","plugin_label":"Example","plugin_id":"example"}'
  $DCG d8:plugin:field:type -d $MODULE_DIR -a '{"name":"Qux","machine_name":"qux","plugin_label":"Example","plugin_id":"example"}'
  $DCG d8:plugin:field:widget -d $MODULE_DIR -a '{"name":"Qux","machine_name":"qux","plugin_label":"Example","plugin_id":"example"}'

  $DCG d8:plugin:migrate:process -d $MODULE_DIR -a '{"name":"Qux","machine_name":"qux","plugin_id":"example"}'

  $DCG d8:plugin:views:argument-default -d $MODULE_DIR -a '{"name":"Qux","machine_name":"qux","plugin_label":"Example","plugin_id":"example"}'
  $DCG d8:plugin:views:field -d $MODULE_DIR -a '{"name":"Qux","machine_name":"qux","plugin_label":"Example","plugin_id":"example"}'
  $DCG d8:plugin:views:style -d $MODULE_DIR -a '{"name":"Qux","machine_name":"qux","plugin_label":"Example","plugin_id":"example"}'

  $DCG d8:plugin:action -d $MODULE_DIR -a '{"name":"Qux","machine_name":"qux","plugin_label":"Update node title","plugin_id":"qux_update_node_title","category":"DCG","configurable":true}'
  $DCG d8:plugin:block -d $MODULE_DIR -a '{"name":"Qux","machine_name":"qux","plugin_label":"Example","plugin_id":"example","category":"DCG"}'
  $DCG d8:plugin:condition -d $MODULE_DIR -a '{"name":"Qux","machine_name":"qux","plugin_label":"Example","plugin_id":"example"}'
  $DCG d8:plugin:filter -d $MODULE_DIR -a '{"name":"Qux","machine_name":"qux","plugin_label":"Example","plugin_id":"example", "filter_type":"HTML restrictor"}'
  $DCG d8:plugin:menu-link -d $MODULE_DIR -a '{"name":"Qux","machine_name":"qux","class":"FooExample"}'
  $DCG d8:plugin:rest-resource -d $MODULE_DIR -a '{"name":"Qux","machine_name":"qux","plugin_label":"Example","plugin_id":"qux_example"}'
  $DCG d8:plugin:entity-reference-selection -d $MODULE_DIR -a '{"name":"Qux","machine_name":"qux","entity_type":"node","plugin_label":"Example","plugin_id":"qux_example","configurable":"yes","class":"ExampleNodeSelection"}'

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

  $DCG d8:service:access-checker -d $MODULE_DIR -a '{"name":"Zippo","machine_name":"zippo","applies_to":"zippo","class":"ZippoAccessChecker"}'
  $DCG d8:service:breadcrumb-builder -d $MODULE_DIR -a '{"name":"Zippo","machine_name":"zippo","class":"ZippoBreadcrumbBuilder"}'
  $DCG d8:service:custom -d $MODULE_DIR -a '{"name":"Zippo","machine_name":"zippo", "service_name":"zippo.example","class":"Example"}'
  $DCG d8:service:event-subscriber -d $MODULE_DIR -a '{"name":"Zippo","machine_name":"zippo"}'
  $DCG d8:service:logger -d $MODULE_DIR -a '{"name":"Zippo","machine_name":"zippo","class":"FileLog"}'
  $DCG d8:service:middleware -d $MODULE_DIR -a '{"name":"Dcg service","machine_name":"zippo"}'
  $DCG d8:service:param-converter -d $MODULE_DIR -a '{"name":"Zippo","machine_name":"zippo","parameter_type":"example","class":"ExampleParamConverter"}'
  $DCG d8:service:route-subscriber -d $MODULE_DIR -a '{"name":"Zippo","machine_name":"zippo"}'
  $DCG d8:service:theme-negotiator -d $MODULE_DIR -a '{"name":"Zippo","machine_name":"zippo","class":"ZippoThemeNegotiator"}'
  $DCG d8:service:twig-extension -d $MODULE_DIR -a '{"name":"Zippo","machine_name":"zippo","class":"ZippoTwigExtension"}'

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

  $DCG d8:test:browser -d $MODULE_DIR -a '{"name":"Xerox", "machine_name":"Xerox","class":"ExampleTest"}'
  $DCG d8:test:javascript -d $MODULE_DIR -a '{"name":"Xerox", "machine_name":"Xerox","class":"ExampleTest"}'
  $DCG d8:test:kernel -d $MODULE_DIR -a '{"name":"Xerox", "machine_name":"Xerox","class":"ExampleTest"}'
  $DCG d8:test:unit -d $MODULE_DIR -a '{"name":"Xerox", "machine_name":"Xerox","class":"ExampleTest"}'
  $DCG d8:test:web -d $MODULE_DIR -a '{"name":"Xerox", "machine_name":"Xerox","class":"ExampleTest"}'

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
  $DCG d8:yml:theme-info -d $MODULE_DIR -a '{"name":"Shreya","machine_name":"shreya","base_theme":"bartic","description":"Helper theme for testing DCG components.","package":"DCG"}'

  dcg_phpcs $THEME_DIR
fi

# --- Test plugin manager --- #
if [ $TARGET_TEST = all -o $TARGET_TEST = plugin_manager ]; then
  dcg_label Plugin manager

  MODULE_MACHINE_NAME=lamda
  MODULE_DIR=$DRUPAL_DIR/modules/$MODULE_MACHINE_NAME

  $DCG d8:module:plugin-manager -d $DRUPAL_DIR/modules -a '{"name":"Lamda","machine_name":"lamda","description":"Helper module for testing plugin manager.","dependencies":"drupal:views","package":"DCG"}'
  cp -R $SELF_PATH/$MODULE_MACHINE_NAME/* $MODULE_DIR

  dcg_phpcs --exclude=Generic.CodeAnalysis.UselessOverridingMethod $MODULE_DIR
  dcg_drush en $MODULE_MACHINE_NAME
  echo $MODULE_DIR/tests
  dcg_phpunit $MODULE_DIR/tests
  dcg_drush pmu $MODULE_MACHINE_NAME
fi

# --- Test configuration entity --- #
if [ $TARGET_TEST = all -o $TARGET_TEST = configuration_entity ]; then
  dcg_label Configuration entity

  MODULE_MACHINE_NAME=wine
  MODULE_DIR=$DRUPAL_DIR/modules/$MODULE_MACHINE_NAME

  $DCG d8:module:configuration-entity -d $DRUPAL_DIR/modules  -a '{"name":"Wine","machine_name":"wine","description":"Configuration entity module generated by DCG.","entity_type_label":"Example","entity_type_id":"example","dependencies":"drupal:views","package":"DCG"}'

  dcg_phpcs $MODULE_DIR
  dcg_drush en $MODULE_MACHINE_NAME
  #dcg_phpunit $MODULE_PATH/tests
  dcg_drush pmu $MODULE_MACHINE_NAME
fi

# --- Test content entity --- #
if [ $TARGET_TEST = all -o $TARGET_TEST = content_entity ]; then
  dcg_label Content entity

  MODULE_MACHINE_NAME=nigma
  MODULE_DIR=$DRUPAL_DIR/modules/$MODULE_MACHINE_NAME

  $DCG d8:module:content-entity -d $DRUPAL_DIR/modules -a '{"name":"Nigma","machine_name":"nigma","description":"Content entity module generated by DCG.","entity_type_label":"Example","entity_type_id":"example","dependencies":"drupal:views","package":"DCG","entity_base_path":"/admin/content/example","fieldable":"yes","revisionable":"yes","template":"yes","access_controller":"yes","title_base_field":"yes","status_base_field":"yes","created_base_field":"yes","changed_base_field":"yes","author_base_field":"yes","description_base_field":"yes","rest_configuration":"yes"}'

  dcg_phpcs $MODULE_DIR
  dcg_drush en $MODULE_MACHINE_NAME
  #dcg_phpunit $MODULE_PATH/tests
  dcg_drush pmu $MODULE_MACHINE_NAME
fi

# --- Test module --- #
if [ $TARGET_TEST = all -o $TARGET_TEST = simmple_module ]; then
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
if [ $TARGET_TEST = all -o $TARGET_TEST = simple_theme ]; then
  dcg_label Theme

  THEME_MACHINE_NAME=azalea
  THEME_DIR=$DRUPAL_DIR/themes/$THEME_MACHINE_NAME

  # Generate a theme.
  $DCG d8:theme -d $DRUPAL_DIR/themes -a '{"name":"Azalea","machine_name":"azalea","base_theme":"bartik","description":"Simple theme generated by DCG.","package":"DCG"}'

  # Code sniffer does not like empty files.
  dcg_phpcs --ignore='\.css' $THEME_DIR
fi
