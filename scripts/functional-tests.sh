#!/usr/bin/env bash
# shellcheck disable=SC2086

# === Configuration. === #
set -o errexit
set -o nounset

ROOT_DIR=$(realpath "$(dirname $0)")/..

DRUPAL_VERSION=${DRUPAL_VERSION:-}
if [[ -z $DRUPAL_VERSION ]]; then
  DRUPAL_VERSION=$(git ls-remote -h https://git.drupalcode.org/project/drupal.git | grep -o '10\..\.x' | tail -n1)
fi
DRUPAL_DIR=${DRUPAL_DIR:-/tmp/dcg_functional/build}
DRUPAL_CACHE_DIR=${DRUPAL_CACHE_DIR:-/tmp/dcg_functional/cache/$DRUPAL_VERSION}
TEST_DIR=$DRUPAL_DIR/vendor/chi-teck/drupal-code-generator/tests/functional

TARGET_TEST=${1:-all}

echo -----------------------------------------------
echo ' DRUPAL PATH:   ' $DRUPAL_DIR
echo ' DRUPAL VERSION:' $DRUPAL_VERSION
echo ' TEST DIR:      ' $TEST_DIR
echo ' ROOT DIR:      ' $ROOT_DIR
echo -----------------------------------------------

# === Helper functions. === #

function dcg_label {
  echo -e "\n\e[30;43m -= $* =- \e[0m\n"
}

function dcg_phpunit {
  $DRUPAL_DIR/vendor/bin/phpunit -c $TEST_DIR $TEST_DIR
}

# === Create a site under testing. === #
if [[ -d $DRUPAL_DIR ]]; then
  chmod -R 777 $DRUPAL_DIR
  rm -rf $DRUPAL_DIR
fi

if [[ -d $DRUPAL_CACHE_DIR ]]; then
  cp -r $DRUPAL_CACHE_DIR $DRUPAL_DIR
else
  export COMPOSER_PROCESS_TIMEOUT=1900
  git clone --depth 1 --branch $DRUPAL_VERSION  https://git.drupalcode.org/project/drupal.git $DRUPAL_DIR
  composer -d$DRUPAL_DIR install
  mkdir -m 777 $DRUPAL_DIR/sites/default/files
  composer -d$DRUPAL_DIR config repositories.dcg path "$ROOT_DIR"
  composer -d$DRUPAL_DIR require chi-teck/drupal-code-generator --ignore-platform-req=php
  php $DRUPAL_DIR/core/scripts/drupal install minimal
  mkdir -p $DRUPAL_CACHE_DIR
  cp -r $DRUPAL_DIR/. $DRUPAL_CACHE_DIR
fi

export SUT_TEST=1
# === Tests === #
dcg_label 'TESTS'
dcg_phpunit

