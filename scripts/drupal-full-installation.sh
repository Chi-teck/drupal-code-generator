#!/usr/bin/env bash
# shellcheck disable=SC2086

# === Configuration. === #
set -Eeuo pipefail

ROOT_DIR=$(realpath "$(dirname $0)")/..

WORKSPACE_DIR=${DCG_TMP_DIR:-/tmp}/dcg_drupal_full
DRUPAL_DIR=$WORKSPACE_DIR/drupal
DRUPAL_REPO='https://git.drupalcode.org/project/drupal.git'

DCG_DRUPAL_VERSION=${DCG_DRUPAL_VERSION:-}
if [[ -z $DCG_DRUPAL_VERSION ]]; then
  # @todo Figure out how to find most recent Drupal core branch open for development.
  DCG_DRUPAL_VERSION=$(git ls-remote -h $DRUPAL_REPO | grep -o '10\.1\.x' | tail -n1)
fi

drush() {
  $DRUPAL_DIR/vendor/bin/drush $@
}

echo -----------------------------------------------
echo ' DRUPAL PATH:   ' $DRUPAL_DIR
echo ' DRUPAL VERSION:' $DCG_DRUPAL_VERSION
echo ' ROOT DIR:      ' $ROOT_DIR
echo -----------------------------------------------

if [[ -d $DRUPAL_DIR ]]; then
  chmod -R 777 $DRUPAL_DIR
  rm -rf $DRUPAL_DIR
fi

echo '🚩 Clone Drupal core'
git clone --depth 1 --branch $DCG_DRUPAL_VERSION $DRUPAL_REPO $DRUPAL_DIR
echo '🚩 Install Composer dependencies'
composer -d$DRUPAL_DIR install
echo '🚩 Install Drupal'
mkdir -m 777 $DRUPAL_DIR/sites/default/files
php $DRUPAL_DIR/core/scripts/drupal install standard
echo '🚩 Install Drush'
composer -d$DRUPAL_DIR require drush/drush
echo '🚩 Check site status'
drush st
echo '🚩 Install all available modules'
MODULES=$(drush pml --filter='status=disabled&&type=module' --field=Name | awk '{print $NF}');
drush en -y $MODULES

