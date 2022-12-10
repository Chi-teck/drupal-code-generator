#!/usr/bin/env bash
# shellcheck disable=SC2086

# === Configuration. === #
set -Eeuo pipefail

ROOT_DIR=$(realpath "$(dirname $0)")/..

WORKSPACE_DIR=${DCG_TMP_DIR:-/tmp}/dcg_functional
DRUPAL_DIR=$WORKSPACE_DIR/drupal
CACHE_DIR=$WORKSPACE_DIR/cache
DCG_DIR=$DRUPAL_DIR/vendor/chi-teck/drupal-code-generator
DRUPAL_REPO='https://git.drupalcode.org/project/drupal.git'

DCG_DRUPAL_VERSION=${DCG_DRUPAL_VERSION:-'10.1.x'}

echo -----------------------------------------------
echo ' DRUPAL PATH:   ' $DRUPAL_DIR
echo ' DRUPAL VERSION:' $DCG_DRUPAL_VERSION
echo ' DCG DIR:       ' $DCG_DIR
echo ' ROOT DIR:      ' $ROOT_DIR
echo -----------------------------------------------

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
  echo '🚩 Install Drupal'
  mkdir -m 777 $DRUPAL_DIR/sites/default/files
  php $DRUPAL_DIR/core/scripts/drupal install standard
  echo '🚩 Update cache'
  if [[ ! -d $CACHE_DIR ]]; then
    mkdir -p $CACHE_DIR
  fi
  cp -r $DRUPAL_DIR $CACHE_DIR/$DCG_DRUPAL_VERSION
fi

echo '🚩 Install local DCG'
composer -d$DRUPAL_DIR config repositories.dcg path "$ROOT_DIR"
composer -d$DRUPAL_DIR require chi-teck/drupal-code-generator --with-all-dependencies
echo '————————————————————————————————————————————'
composer -d$DRUPAL_DIR show --ansi chi-teck/drupal-code-generator | head -n 10
echo '————————————————————————————————————————————'

echo '🚩 Run tests'
$DRUPAL_DIR/vendor/bin/phpunit -c $DCG_DIR --testsuite=functional ${1:-}
