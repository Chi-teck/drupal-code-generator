#!/usr/bin/env bash
# shellcheck disable=SC2086

# === Configuration. === #
set -Eeuo pipefail

ROOT_DIR=$(realpath "$(dirname $0)")/..

DRUPAL_VERSION=${DRUPAL_VERSION:-}
if [[ -z $DRUPAL_VERSION ]]; then
  DRUPAL_VERSION=$(git ls-remote -h https://git.drupalcode.org/project/drupal.git | grep -o '10\..\.x' | tail -n1)
fi
WORKSPACE_DIR=${WORKSPACE_DIR:-/tmp/dcg_functional}
DRUPAL_DIR=$WORKSPACE_DIR/drupal
CACHE_DIR=$WORKSPACE_DIR/cache
DCG_DIR=$DRUPAL_DIR/vendor/chi-teck/drupal-code-generator

echo -----------------------------------------------
echo ' DRUPAL PATH:   ' $DRUPAL_DIR
echo ' DRUPAL VERSION:' $DRUPAL_VERSION
echo ' DCG DIR:       ' $DCG_DIR
echo ' ROOT DIR:      ' $ROOT_DIR
echo -----------------------------------------------

if [[ -d $DRUPAL_DIR ]]; then
  chmod -R 777 $DRUPAL_DIR
  rm -rf $DRUPAL_DIR
fi

if [[ -d $CACHE_DIR/$DRUPAL_VERSION ]]; then
  echo '🚩 Install Drupal from cache'
  cp -r $CACHE_DIR/$DRUPAL_VERSION $DRUPAL_DIR
else
  echo '🚩 Clone Drupal core'
  git clone --depth 1 --branch $DRUPAL_VERSION  https://git.drupalcode.org/project/drupal.git $DRUPAL_DIR
  echo '🚩 Install Composer dependencies'
  composer -d$DRUPAL_DIR install
  echo '🚩 Install local DCG'
  composer -d$DRUPAL_DIR config repositories.dcg path "$ROOT_DIR"
  composer -d$DRUPAL_DIR require chi-teck/drupal-code-generator --ignore-platform-req=php
  echo '🚩 Install Drupal'
  mkdir -m 777 $DRUPAL_DIR/sites/default/files
  php $DRUPAL_DIR/core/scripts/drupal install standard
  echo '🚩 Update cache'
  if [[ ! -d $CACHE_DIR ]]; then
    mkdir -p $CACHE_DIR
  fi
  cp -r $DRUPAL_DIR $CACHE_DIR/$DRUPAL_VERSION
fi

echo '🚩 Run tests'
$DRUPAL_DIR/vendor/bin/phpunit -c $DCG_DIR --testsuite=functional
