#!/usr/bin/env bash
# shellcheck disable=SC2086

# === Configuration. === #
set -Eeuo pipefail

root_dir=$(realpath "$(dirname $0)")/..

workspace_dir=${DCG_TMP_DIR:-/tmp}/dcg_drupal_full
drupal_dir=$workspace_dir/drupal
drupal_repo='https://git.drupalcode.org/project/drupal.git'

dcg_drupal_version=${DCG_DRUPAL_VERSION:-}
if [[ -z $dcg_drupal_version ]]; then
  # @todo Figure out how to find most recent Drupal core branch open for development.
  dcg_drupal_version=$(git ls-remote -h $drupal_repo | grep -o '10\.1\.x' | tail -n1)
fi

drush() {
  $drupal_dir/vendor/bin/drush "$@"
}

echo -----------------------------------------------
echo ' DRUPAL PATH:   ' $drupal_dir
echo ' DRUPAL VERSION:' $dcg_drupal_version
echo ' ROOT DIR:      ' $root_dir
echo -----------------------------------------------

if [[ -d $drupal_dir ]]; then
  chmod -R 777 $drupal_dir
  rm -rf $drupal_dir
fi

echo '🚩 Clone Drupal core'
git clone --depth 1 --branch $dcg_drupal_version $drupal_repo $drupal_dir
echo '🚩 Install Composer dependencies'
composer -d$drupal_dir install
echo '🚩 Install Drupal'
mkdir -m 777 $drupal_dir/sites/default/files
php $drupal_dir/core/scripts/drupal install standard
echo '🚩 Install Drush'
composer -d$drupal_dir require drush/drush
echo '🚩 Check site status'
drush st
echo '🚩 Install all available modules'
modules=$(drush pml --filter='status=disabled&&type=module' --field=Name | awk '{print $NF}');
drush en -y $modules

