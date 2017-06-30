#!/usr/bin/env bash

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

echo --------------------------------------
echo ' DRUPAL_PATH:   ' $DRUPAL_PATH
echo ' DRUPAL_VERSION:' $DRUPAL_VERSION
echo ' DRUPAL_HOST:   ' $SUT_HOST
echo ' DRUPAL_PORT:   ' $SUT_PORT
echo ' DCG:           ' $DCG
echo --------------------------------------

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

# Run tests.
echo -e "\n\e[30;43m -= Components =- \e[0m\n"
source $SELF_PATH/components/test.sh
