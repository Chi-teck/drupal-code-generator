#!/usr/bin/env bash

# === Configuration. === #

set -e
function dcg_on_exit {
  if [ $? -eq 0 ] ; then
    echo -e "\n\e[0;42m SUCCESS \e[0m"
  else
    echo -e "\n\e[0;41m FAIL \e[0m"
  fi
}
trap dcg_on_exit EXIT

SELF_PATH=$(dirname $0)
DRUPAL_PATH=${DRUPAL_PATH:-/tmp/dcg_sut}
DRUPAL_VERSION=${DRUPAL_VERSION:-8.4.x-dev}
SUT_HOST=${SUT_HOST:-127.0.0.1}
SUT_PORT=${SUT_PORT:-8085}
DCG=${DCG:-/var/www/dcg/bin/dcg}
TARGET_TEST=${1:-all}

echo --------------------------------------
echo ' DRUPAL_PATH:   ' $DRUPAL_PATH
echo ' DRUPAL_VERSION:' $DRUPAL_VERSION
echo ' DRUPAL_HOST:   ' $SUT_HOST
echo ' DRUPAL_PORT:   ' $SUT_PORT
echo ' DCG:           ' $DCG
echo --------------------------------------

# === Helper functions. === #

function dcg_drush {
  $DRUPAL_PATH/vendor/bin/drush -r $DRUPAL_PATH -y $@
}

function dcg_phpcs {
  $DRUPAL_PATH/vendor/bin/phpcs --standard=Drupal,DrupalPractice $@
}

function dcg_phpunit {
  SIMPLETEST_BASE_URL=http://$SUT_HOST:$SUT_PORT \
  SIMPLETEST_DB=sqlite://sites/default/files/.ht.sqlite#st_ \
  $DRUPAL_PATH/vendor/bin/phpunit \
  -c $DRUPAL_PATH/core $@
}

# === Create a site under testing. === #

# Assuming that global Drush is not installed.
sudo rm -rf $DRUPAL_PATH
wget -P /tmp https://ftp.drupal.org/files/projects/drupal-$DRUPAL_VERSION.tar.gz
tar xf /tmp/drupal-$DRUPAL_VERSION.tar.gz -C /tmp
mv /tmp/drupal-$DRUPAL_VERSION $DRUPAL_PATH
rm /tmp/drupal-$DRUPAL_VERSION.tar.gz
composer -d=$DRUPAL_PATH require drush/drush:dev-master
mkdir -m 777 $DRUPAL_PATH/sites/default/files
composer -d=$DRUPAL_PATH update squizlabs/php_codesniffer
$DRUPAL_PATH/vendor/bin/phpcs --config-set installed_paths $DRUPAL_PATH/vendor/drupal/coder/coder_sniffer
dcg_drush si minimal --db-url=sqlite://sites/default/files/.ht.sqlite

IS_RUNNING=$(netstat -lnt | awk "/$SUT_HOST:$SUT_PORT/ { print \"FOUND\" }")
if [ -z "$IS_RUNNING" ]; then
  echo Staring server...
  php -S $SUT_HOST:$SUT_PORT -t $DRUPAL_PATH &>/dev/null &
fi

# === Tests === #

# --- Test forms --- #
if [ $TARGET_TEST = all -o $TARGET_TEST = form ]; then
  echo -e "\n\e[30;43m -= Form =- \e[0m\n"

  MODULE_MACHINE_NAME=foo
  MODULE_PATH=$DRUPAL_PATH/modules/$MODULE_MACHINE_NAME

  cp -R $SELF_PATH/$MODULE_MACHINE_NAME $MODULE_PATH

  # Generate forms.
  $DCG -d$MODULE_PATH d8:form:simple -a'{"name":"Foo","machine_name":"foo","class":"SimpleForm","form_id":"foo_simple"}'
  $DCG -d$MODULE_PATH d8:form:config -a'{"name":"Foo","machine_name":"foo","class":"SettingsForm","form_id":"foo_settings"}'
  $DCG -d$MODULE_PATH d8:form:confirm -a'{"name":"Foo","machine_name":"foo","class":"ConfirmForm","form_id":"foo_confirm"}'

  dcg_phpcs --exclude=DrupalPractice.Yaml.RoutingAccess $MODULE_PATH
  dcg_drush en $MODULE_MACHINE_NAME
  dcg_phpunit $MODULE_PATH/tests
  dcg_drush pmu $MODULE_MACHINE_NAME
fi


# --- Test module components --- #
if [ $TARGET_TEST = all -o $TARGET_TEST = module_component ]; then
  echo -e "\n\e[30;43m -= Module component =- \e[0m\n"

  MODULE_MACHINE_NAME=bar
  MODULE_PATH=$DRUPAL_PATH/modules/$MODULE_MACHINE_NAME

  cp -R $SELF_PATH/$MODULE_MACHINE_NAME $MODULE_PATH

  # Generate controller.
  $DCG -d$MODULE_PATH d8:controller -a'{"name":"Bar","machine_name":"bar","class":"BarController","route":true,"route_name":"bar.example","route_path":"/bar/example","route_title":"Example","route_permission":"access content"}'

  dcg_phpcs $MODULE_PATH
  dcg_drush en $MODULE_MACHINE_NAME
  dcg_phpunit $MODULE_PATH/tests
  dcg_drush pmu $MODULE_MACHINE_NAME
fi

# --- Test plugins --- #
if [ $TARGET_TEST = all -o $TARGET_TEST = plugin ]; then
  echo -e "\n\e[30;43m -= Plugin =- \e[0m\n"

  MODULE_MACHINE_NAME=qux
  MODULE_PATH=$DRUPAL_PATH/modules/$MODULE_MACHINE_NAME

  cp -R $SELF_PATH/$MODULE_MACHINE_NAME $MODULE_PATH

  # Generate plugins.
  $DCG -d$MODULE_PATH d8:plugin:field:formatter -a'{"name":"Qux","machine_name":"qux","plugin_label":"Example","plugin_id":"example"}'
  $DCG -d$MODULE_PATH d8:plugin:field:type -a'{"name":"Qux","machine_name":"qux","plugin_label":"Example","plugin_id":"example"}'
  $DCG -d$MODULE_PATH d8:plugin:field:widget -a'{"name":"Qux","machine_name":"qux","plugin_label":"Example","plugin_id":"example"}'

  $DCG -d$MODULE_PATH d8:plugin:views:argument-default -a'{"name":"Qux","machine_name":"qux","plugin_label":"Example","plugin_id":"example"}'
  $DCG -d$MODULE_PATH d8:plugin:views:field -a'{"name":"Qux","machine_name":"qux","plugin_label":"Example","plugin_id":"example"}'
  $DCG -d$MODULE_PATH d8:plugin:views:style -a'{"name":"Qux","machine_name":"qux","plugin_label":"Example","plugin_id":"example"}'

  $DCG -d$MODULE_PATH d8:plugin:action -a'{"name":"Qux","machine_name":"qux","plugin_label":"Example","plugin_id":"example","category":"DCG","configurable":true}'
  $DCG -d$MODULE_PATH d8:plugin:block -a'{"name":"Qux","machine_name":"qux","plugin_label":"Example","plugin_id":"example","category":"DCG"}'
  $DCG -d$MODULE_PATH d8:plugin:condition -a'{"name":"Qux","machine_name":"qux","plugin_label":"Example","plugin_id":"example"}'
  $DCG -d$MODULE_PATH d8:plugin:filter -a'{"name":"Qux","machine_name":"qux","plugin_label":"Example","plugin_id":"example", "filter_type":"HTML restrictor"}'
  $DCG -d$MODULE_PATH d8:plugin:menu-link -a'{"name":"Qux","machine_name":"qux","class":"FooExample"}'
  $DCG -d$MODULE_PATH d8:plugin:rest-resource -a'{"name":"Qux","machine_name":"qux","plugin_label":"Example","plugin_id":"example"}'

  dcg_phpcs $MODULE_PATH
  dcg_drush en $MODULE_MACHINE_NAME
  #dcg_phpunit $MODULE_PATH/tests
  dcg_drush pmu $MODULE_MACHINE_NAME
fi

# --- Test services --- #
if [ $TARGET_TEST = all -o $TARGET_TEST = service ]; then
  echo -e "\n\e[30;43m -= Service =- \e[0m\n"

  MODULE_MACHINE_NAME=zippo
  MODULE_PATH=$DRUPAL_PATH/modules/$MODULE_MACHINE_NAME

  cp -R $SELF_PATH/$MODULE_MACHINE_NAME $MODULE_PATH

  # Generate services.
  $DCG -d$MODULE_PATH d8:service:access-checker -a'{"name":"Zippo","machine_name":"zippo","applies_to":"zippo","class":"ZippoAccessChecker"}'
  $DCG -d$MODULE_PATH d8:service:breadcrumb-builder -a'{"name":"Zippo","machine_name":"zippo","class":"ZippoBreadcrumbBuilder"}'
  $DCG -d$MODULE_PATH d8:service:custom -a'{"name":"Zippo","machine_name":"zippo", "service_name":"zippo.example","class":"Example"}'
  $DCG -d$MODULE_PATH d8:service:event-subscriber -a'{"name":"Zippo","machine_name":"zippo"}'
  $DCG -d$MODULE_PATH d8:service:middleware -a'{"name":"Dcg service","machine_name":"zippo"}'
  $DCG -d$MODULE_PATH d8:service:param-converter -a'{"name":"Zippo","machine_name":"zippo","parameter_type":"example","class":"ExampleParamConverter"}'
  $DCG -d$MODULE_PATH d8:service:route-subscriber -a'{"name":"Zippo","machine_name":"zippo"}'
  $DCG -d$MODULE_PATH d8:service:twig-extension -a'{"name":"Zippo","machine_name":"zippo","class":"ZippoTwigExtension"}'

  dcg_phpcs $MODULE_PATH
  dcg_drush en $MODULE_MACHINE_NAME
  dcg_phpunit $MODULE_PATH/tests
  dcg_drush pmu $MODULE_MACHINE_NAME
fi

# --- Test YML --- #
if [ $TARGET_TEST = all -o $TARGET_TEST = yml ]; then
  echo -e "\n\e[30;43m -= YML =- \e[0m\n"

  MODULE_MACHINE_NAME=yety
  MODULE_PATH=$DRUPAL_PATH/modules/$MODULE_MACHINE_NAME

  cp -R $SELF_PATH/$MODULE_MACHINE_NAME $MODULE_PATH

  # Generate YML files.
  $DCG -d$MODULE_PATH d8:yml:action-links -a'{"machine_name":"yety"}'
  $DCG -d$MODULE_PATH d8:yml:menu-links -a'{"machine_name":"yety"}'
  $DCG -d$MODULE_PATH d8:yml:module-info -a'{"name":"Yety","machine_name":"yety","description":"Helper module for testing generated YML files.", "package": "DCG","configure":"", "dependencies":""}'
  $DCG -d$MODULE_PATH d8:yml:module-libraries -a'{"name":"Yety","machine_name":"yety"}'
  $DCG -d$MODULE_PATH d8:yml:permissions -a'{"machine_name":"yety"}'
  $DCG -d$MODULE_PATH d8:yml:routing -a'{"name":"Yety","machine_name":"yety"}'
  $DCG -d$MODULE_PATH d8:yml:services -a'{"name":"Yety","machine_name":"yety"}'
  $DCG -d$MODULE_PATH d8:yml:task-links -a'{"machine_name":"yety"}'
  $DCG -d$MODULE_PATH d8:yml:contextual-links -a'{"machine_name":"yety"}'

  dcg_phpcs $MODULE_PATH
  dcg_drush en $MODULE_MACHINE_NAME
  #dcg_phpunit $MODULE_PATH/tests
  dcg_drush pmu $MODULE_MACHINE_NAME
fi
