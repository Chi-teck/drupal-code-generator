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

SELF_PATH=$(dirname $0)
DRUPAL_VERSION=${DRUPAL_VERSION:-8.5.x-dev}
DRUPAL_DIR=${DRUPAL_DIR:-/tmp/dcg_sut}
DRUPAL_CACHED_DIR=${DRUPAL_CACHED_DIR:-/tmp/dcg_sut_cached/$DRUPAL_VERSION}
DRUPAL_HOST=${DRUPAL_HOST:-127.0.0.1}
DRUPAL_PORT=${DRUPAL_PORT:-8085}
DEFAULT_DCG=$(realpath $(dirname $0)/../../bin/dcg)
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
# Use Drush router PHP built-in server cannot handle routers with dots.
# See https://bugs.php.net/bug.php?id=61286.
$DRUPAL_DIR/vendor/bin/web.server \
  start \
  $DRUPAL_HOST:$DRUPAL_PORT \
  --docroot=$DRUPAL_DIR \
  --router=$DRUPAL_DIR/vendor/drush/drush/misc/d8-rs-router.php

# === Tests === #

# --- Test forms --- #
if [ $TARGET_TEST = all -o $TARGET_TEST = form ]; then
  echo -e "\n\e[30;43m -= Form =- \e[0m\n"

  MODULE_MACHINE_NAME=foo
  MODULE_DIR=$DRUPAL_DIR/modules/$MODULE_MACHINE_NAME

  cp -R $SELF_PATH/$MODULE_MACHINE_NAME $MODULE_DIR

  # Generate forms.
  $DCG -d$MODULE_DIR d8:form:simple -a'{"name":"Foo","machine_name":"foo","class":"SimpleForm","form_id":"foo_simple","route":"Yes","route_name":"foo_simple_form","route_path":"/admin/config/foo/simple","route_title":"example","route_permission":"access administration pages"}'
  $DCG -d$MODULE_DIR d8:form:config -a'{"name":"Foo","machine_name":"foo","class":"SettingsForm","form_id":"foo_config","route":"Yes","route_name":"foo_config_form","route_path":"/admin/config/foo/settings","route_title":"example","route_permission":"access administration pages"}'
  $DCG -d$MODULE_DIR d8:form:confirm -a'{"name":"Foo","machine_name":"foo","class":"ConfirmForm","form_id":"foo_confirm", "route":"Yes","route_name":"foo_confirm_form","route_path":"/admin/config/foo/confirm","route_title":"example","route_permission":"access administration pages"}'

  dcg_phpcs --exclude=DrupalPractice.Yaml.RoutingAccess $MODULE_DIR
  dcg_drush en $MODULE_MACHINE_NAME
  dcg_phpunit $MODULE_DIR/tests
  dcg_drush pmu $MODULE_MACHINE_NAME
fi

# --- Test module components --- #
if [ $TARGET_TEST = all -o $TARGET_TEST = module_component ]; then
  echo -e "\n\e[30;43m -= Module component =- \e[0m\n"

  MODULE_MACHINE_NAME=bar
  MODULE_DIR=$DRUPAL_DIR/modules/$MODULE_MACHINE_NAME

  cp -R $SELF_PATH/$MODULE_MACHINE_NAME $MODULE_DIR

  # Generate module components.
  $DCG -d$MODULE_DIR d8:composer -a'{"machine_name":"bar","description":"Bar project.","type":"drupal-module","drupal_org":"Yes"}'
  $DCG -d$MODULE_DIR d8:controller -a'{"name":"Bar","machine_name":"bar","class":"BarController","route":true,"route_name":"bar.example","route_path":"/bar/example","route_title":"Example","route_permission":"access content"}'
  $DCG -d$MODULE_DIR d8:install -a'{"name":"Bar","machine_name":"bar"}'
  $DCG -d$MODULE_DIR d8:javascript -a'{"name":"Bar","machine_name":"bar"}'
  $DCG -d$MODULE_DIR d8:module-file -a'{"name":"Bar","machine_name":"bar"}'
  $DCG -d$MODULE_DIR d8:service-provider -a'{"name":"Bar","machine_name":"bar"}'
  $DCG -d$MODULE_DIR d8:template -a'{"name":"Bar","machine_name":"bar","template_name":"example","create_theme":"yes","create_preprocess":"yes"}'
  $DCG -d$MODULE_DIR d8:layout -a'{"machine_name":"bar","layout_name":"Foo","layout_machine_name":"foo","category":"my","js":"Yes","css":"Yes"}'

  dcg_phpcs $MODULE_DIR
  dcg_drush en $MODULE_MACHINE_NAME
  dcg_phpunit $MODULE_DIR/tests
  dcg_drush pmu $MODULE_MACHINE_NAME
fi

# --- Test plugins --- #
if [ $TARGET_TEST = all -o $TARGET_TEST = plugin ]; then
  echo -e "\n\e[30;43m -= Plugin =- \e[0m\n"

  MODULE_MACHINE_NAME=qux
  MODULE_DIR=$DRUPAL_DIR/modules/$MODULE_MACHINE_NAME

  cp -R $SELF_PATH/$MODULE_MACHINE_NAME $MODULE_DIR

  # Generate plugins.
  $DCG -d$MODULE_DIR d8:plugin:field:formatter -a'{"name":"Qux","machine_name":"qux","plugin_label":"Example","plugin_id":"example"}'
  $DCG -d$MODULE_DIR d8:plugin:field:type -a'{"name":"Qux","machine_name":"qux","plugin_label":"Example","plugin_id":"example"}'
  $DCG -d$MODULE_DIR d8:plugin:field:widget -a'{"name":"Qux","machine_name":"qux","plugin_label":"Example","plugin_id":"example"}'

  $DCG -d$MODULE_DIR d8:plugin:migrate:process -a'{"name":"Qux","machine_name":"qux","plugin_id":"example"}'

  $DCG -d$MODULE_DIR d8:plugin:views:argument-default -a'{"name":"Qux","machine_name":"qux","plugin_label":"Example","plugin_id":"example"}'
  $DCG -d$MODULE_DIR d8:plugin:views:field -a'{"name":"Qux","machine_name":"qux","plugin_label":"Example","plugin_id":"example"}'
  $DCG -d$MODULE_DIR d8:plugin:views:style -a'{"name":"Qux","machine_name":"qux","plugin_label":"Example","plugin_id":"example"}'

  $DCG -d$MODULE_DIR d8:plugin:action -a'{"name":"Qux","machine_name":"qux","plugin_label":"Update node title","plugin_id":"qux_update_node_title","category":"DCG","configurable":true}'
  $DCG -d$MODULE_DIR d8:plugin:block -a'{"name":"Qux","machine_name":"qux","plugin_label":"Example","plugin_id":"example","category":"DCG"}'
  $DCG -d$MODULE_DIR d8:plugin:condition -a'{"name":"Qux","machine_name":"qux","plugin_label":"Example","plugin_id":"example"}'
  $DCG -d$MODULE_DIR d8:plugin:filter -a'{"name":"Qux","machine_name":"qux","plugin_label":"Example","plugin_id":"example", "filter_type":"HTML restrictor"}'
  $DCG -d$MODULE_DIR d8:plugin:menu-link -a'{"name":"Qux","machine_name":"qux","class":"FooExample"}'
  $DCG -d$MODULE_DIR d8:plugin:rest-resource -a'{"name":"Qux","machine_name":"qux","plugin_label":"Example","plugin_id":"example"}'

  dcg_phpcs $MODULE_DIR
  dcg_drush en $MODULE_MACHINE_NAME
  dcg_phpunit $MODULE_DIR/tests
  dcg_drush pmu $MODULE_MACHINE_NAME
fi

# --- Test services --- #
if [ $TARGET_TEST = all -o $TARGET_TEST = service ]; then
  echo -e "\n\e[30;43m -= Service =- \e[0m\n"

  MODULE_MACHINE_NAME=zippo
  MODULE_DIR=$DRUPAL_DIR/modules/$MODULE_MACHINE_NAME

  cp -R $SELF_PATH/$MODULE_MACHINE_NAME $MODULE_DIR

  # Generate services.
  $DCG -d$MODULE_DIR d8:service:access-checker -a'{"name":"Zippo","machine_name":"zippo","applies_to":"zippo","class":"ZippoAccessChecker"}'
  $DCG -d$MODULE_DIR d8:service:breadcrumb-builder -a'{"name":"Zippo","machine_name":"zippo","class":"ZippoBreadcrumbBuilder"}'
  $DCG -d$MODULE_DIR d8:service:custom -a'{"name":"Zippo","machine_name":"zippo", "service_name":"zippo.example","class":"Example"}'
  $DCG -d$MODULE_DIR d8:service:event-subscriber -a'{"name":"Zippo","machine_name":"zippo"}'
  $DCG -d$MODULE_DIR d8:service:middleware -a'{"name":"Dcg service","machine_name":"zippo"}'
  $DCG -d$MODULE_DIR d8:service:param-converter -a'{"name":"Zippo","machine_name":"zippo","parameter_type":"example","class":"ExampleParamConverter"}'
  $DCG -d$MODULE_DIR d8:service:route-subscriber -a'{"name":"Zippo","machine_name":"zippo"}'
  $DCG -d$MODULE_DIR d8:service:twig-extension -a'{"name":"Zippo","machine_name":"zippo","class":"ZippoTwigExtension"}'

  dcg_phpcs $MODULE_DIR
  dcg_drush en $MODULE_MACHINE_NAME
  dcg_phpunit $MODULE_DIR/tests
  dcg_drush pmu $MODULE_MACHINE_NAME
fi

# --- Test YML --- #
if [ $TARGET_TEST = all -o $TARGET_TEST = yml ]; then
  echo -e "\n\e[30;43m -= YML =- \e[0m\n"

  MODULE_MACHINE_NAME=yety
  MODULE_DIR=$DRUPAL_DIR/modules/$MODULE_MACHINE_NAME

  cp -R $SELF_PATH/$MODULE_MACHINE_NAME $MODULE_DIR

  # Generate YML files.
  $DCG -d$MODULE_DIR d8:yml:links:action -a'{"machine_name":"yety"}'
  $DCG -d$MODULE_DIR d8:yml:links:contextual -a'{"machine_name":"yety"}'
  $DCG -d$MODULE_DIR d8:yml:links:menu -a'{"machine_name":"yety"}'
  $DCG -d$MODULE_DIR d8:yml:links:task -a'{"machine_name":"yety"}'
  $DCG -d$MODULE_DIR d8:yml:module-info -a'{"name":"Yety","machine_name":"yety","description":"Helper module for testing generated YML files.", "package": "DCG","configure":"", "dependencies":""}'
  $DCG -d$MODULE_DIR d8:yml:module-libraries -a'{"name":"Yety","machine_name":"yety"}'
  $DCG -d$MODULE_DIR d8:yml:permissions -a'{"machine_name":"yety"}'
  $DCG -d$MODULE_DIR d8:yml:routing -a'{"name":"Yety","machine_name":"yety"}'
  $DCG -d$MODULE_DIR d8:yml:services -a'{"name":"Yety","machine_name":"yety"}'

  dcg_phpcs $MODULE_DIR
  dcg_drush en $MODULE_MACHINE_NAME
  #dcg_phpunit $MODULE_PATH/tests
  dcg_drush pmu $MODULE_MACHINE_NAME
fi

# --- Test tests --- #
if [ $TARGET_TEST = all -o $TARGET_TEST = test ]; then
  echo -e "\n\e[30;43m -= Test =- \e[0m\n"

  MODULE_MACHINE_NAME=xerox
  MODULE_DIR=$DRUPAL_DIR/modules/$MODULE_MACHINE_NAME

  cp -R $SELF_PATH/$MODULE_MACHINE_NAME $MODULE_DIR

  # Generate tests.
  $DCG -d$MODULE_DIR d8:test:browser -a'{"name":"Xerox", "machine_name":"Xerox","class":"ExampleTest"}'
  $DCG -d$MODULE_DIR d8:test:javascript -a'{"name":"Xerox", "machine_name":"Xerox","class":"ExampleTest"}'
  $DCG -d$MODULE_DIR d8:test:kernel -a'{"name":"Xerox", "machine_name":"Xerox","class":"ExampleTest"}'
  $DCG -d$MODULE_DIR d8:test:unit -a'{"name":"Xerox", "machine_name":"Xerox","class":"ExampleTest"}'
  $DCG -d$MODULE_DIR d8:test:web -a'{"name":"Xerox", "machine_name":"Xerox","class":"ExampleTest"}'

  dcg_phpcs --exclude=Generic.CodeAnalysis.UselessOverridingMethod $MODULE_DIR
  dcg_drush en $MODULE_MACHINE_NAME
  dcg_phpunit $MODULE_DIR/tests
  dcg_drush pmu $MODULE_MACHINE_NAME
fi

# --- Test theme components --- #
if [ $TARGET_TEST = all -o $TARGET_TEST = theme_component ]; then
  echo -e "\n\e[30;43m -= Theme component =- \e[0m\n"

  THEME_MACHINE_NAME=shreya
  THEME_DIR=$DRUPAL_DIR/themes/$THEME_MACHINE_NAME

  mkdir $THEME_DIR

  # Generate theme components.
  $DCG -d$THEME_DIR d8:theme-file -a'{"name":"Shreya","machine_name":"shreya"}'
  $DCG -d$THEME_DIR d8:yml:breakpoints -a'{"machine_name":"shreya"}'
  $DCG -d$THEME_DIR d8:theme-settings -a'{"name":"Shreya","machine_name":"shreya"}'
  $DCG -d$THEME_DIR d8:yml:theme-libraries -a'{"machine_name":"shreya"}'
  $DCG -d$THEME_DIR d8:yml:theme-info -a'{"name":"Shreya","machine_name":"shreya","base_theme":"bartic","description":"Helper theme for testing DCG components.","package":"DCG"}'

  dcg_phpcs $THEME_DIR
fi

# --- Test plugin manager --- #
if [ $TARGET_TEST = all -o $TARGET_TEST = plugin_manager ]; then
  echo -e "\n\e[30;43m -= Plugin manager =- \e[0m\n"

  MODULE_MACHINE_NAME=lamda
  MODULE_DIR=$DRUPAL_DIR/modules/$MODULE_MACHINE_NAME

  # Generate plugin manager.
  $DCG -d$DRUPAL_DIR/modules d8:module:plugin-manager -a'{"name":"Lamda","machine_name":"lamda","description":"Helper module for testing plugin manager.","dependencies":"drupal:views","package":"DCG"}'
  cp -R $SELF_PATH/$MODULE_MACHINE_NAME/* $MODULE_DIR

  dcg_phpcs --exclude=Generic.CodeAnalysis.UselessOverridingMethod $MODULE_DIR
  dcg_drush en $MODULE_MACHINE_NAME
  echo $MODULE_DIR/tests
  dcg_phpunit $MODULE_DIR/tests
  dcg_drush pmu $MODULE_MACHINE_NAME
fi

# --- Test configuration entity --- #
if [ $TARGET_TEST = all -o $TARGET_TEST = configuration_entity ]; then
  echo -e "\n\e[30;43m -= Configuration entity =- \e[0m\n"

  MODULE_MACHINE_NAME=wine
  MODULE_DIR=$DRUPAL_DIR/modules/$MODULE_MACHINE_NAME

  #cp -R $SELF_PATH/$MODULE_MACHINE_NAME $MODULE_PATH

  # Generate configuration entity.
  $DCG -d$DRUPAL_DIR/modules d8:module:configuration-entity -a'{"name":"Wine","machine_name":"wine","description":"Configuration entity module generated by DCG.","entity_type_label":"Example","entity_type_id":"example","dependencies":"drupal:views","package":"DCG"}'

  dcg_phpcs $MODULE_DIR
  dcg_drush en $MODULE_MACHINE_NAME
  #dcg_phpunit $MODULE_PATH/tests
  dcg_drush pmu $MODULE_MACHINE_NAME
fi

# --- Test content entity --- #
if [ $TARGET_TEST = all -o $TARGET_TEST = content_entity ]; then
  echo -e "\n\e[30;43m -= Content entity =- \e[0m\n"

  MODULE_MACHINE_NAME=nigma
  MODULE_DIR=$DRUPAL_DIR/modules/$MODULE_MACHINE_NAME

  #cp -R $SELF_PATH/$MODULE_MACHINE_NAME $MODULE_PATH

  # Generate content entity.
  $DCG -d$DRUPAL_DIR/modules d8:module:content-entity -a'{"name":"Nigma","machine_name":"nigma","description":"Content entity module generated by DCG.","entity_type_label":"Example","entity_type_id":"example","dependencies":"drupal:views","package":"DCG","entity_base_path":"/admin/content/example","fieldable":"yes","revisionable":"yes","template":"yes","access_controller":"yes","title_base_field":"yes","status_base_field":"yes","created_base_field":"yes","changed_base_field":"yes","author_base_field":"yes","description_base_field":"yes","rest_configuration":"yes"}'

  dcg_phpcs $MODULE_DIR
  dcg_drush en $MODULE_MACHINE_NAME
  #dcg_phpunit $MODULE_PATH/tests
  dcg_drush pmu $MODULE_MACHINE_NAME
fi

# --- Test module --- #
if [ $TARGET_TEST = all -o $TARGET_TEST = standard_module ]; then
  echo -e "\n\e[30;43m -= Standard module =- \e[0m\n"

  MODULE_MACHINE_NAME=peach
  MODULE_DIR=$DRUPAL_DIR/modules/$MODULE_MACHINE_NAME

  #cp -R $SELF_PATH/$MODULE_MACHINE_NAME $MODULE_PATH

  # Generate standard module.
  $DCG -d$DRUPAL_DIR/modules d8:module:standard -a'{"name":"Peach","machine_name":"peach","description":"Standard module generated by DCG.","dependencies":"drupal:views, drupal:node, drupal:action","package":"DCG","install_file":"Yes","libraries.yml":"Yes","permissions.yml":"Yes","event_subscriber":"Yes","block_plugin":"Yes","controller":"Yes","settings_form":"Yes"}'

  dcg_phpcs $MODULE_DIR
  dcg_drush en $MODULE_MACHINE_NAME
  #dcg_phpunit $MODULE_PATH/tests
  dcg_drush pmu $MODULE_MACHINE_NAME
fi

# --- Test theme --- #
if [ $TARGET_TEST = all -o $TARGET_TEST = standard_theme ]; then
  echo -e "\n\e[30;43m -= Standard theme =- \e[0m\n"

  THEME_MACHINE_NAME=azalea
  THEME_DIR=$DRUPAL_DIR/themes/$THEME_MACHINE_NAME

  # Generate standard module.
  $DCG -d$DRUPAL_DIR/themes d8:theme:standard -a'{"name":"Azalea","machine_name":"azalea","base_theme":"bartik","description":"Standard theme generated by DCG.","package":"DCG"}'

  # Code sniffer does not like empty files.
  dcg_phpcs --ignore='\.css' $THEME_DIR
fi
