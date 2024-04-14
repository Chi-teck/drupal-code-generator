#!/usr/bin/env bash
# shellcheck disable=SC2086

# === Configuration. === #
set -Eeuo pipefail

root_dir=$(realpath "$(dirname $0)")/..

workspace_dir=${DCG_TMP_DIR:-/tmp}/dcg_functional
drupal_dir=$workspace_dir/drupal
cache_dir=$workspace_dir/cache
dcg_dir=$drupal_dir/vendor/chi-teck/drupal-code-generator
drupal_repo='https://git.drupalcode.org/project/drupal.git'
dcg_drupal_version=${DCG_DRUPAL_VERSION:-'11.x'}

echo -----------------------------------------------
echo ' DRUPAL PATH:   ' $drupal_dir
echo ' DRUPAL VERSION:' $dcg_drupal_version
echo ' DCG DIR:       ' $dcg_dir
echo ' ROOT DIR:      ' $root_dir
echo -----------------------------------------------

if [[ -d $drupal_dir ]]; then
  chmod -R 777 $drupal_dir
  rm -rf $drupal_dir
fi

if [[ -d $cache_dir/$dcg_drupal_version ]]; then
  echo '🚩 Install Drupal from cache'
  cp -r $cache_dir/$dcg_drupal_version $drupal_dir
else
  echo '🚩 Clone Drupal core'
  git clone --depth 1 --branch $dcg_drupal_version $drupal_repo $drupal_dir
  echo '🚩 Install Composer dependencies'
  composer -d$drupal_dir install
  echo '🚩 Install Drupal'
  mkdir -m 777 $drupal_dir/sites/default/files
  php $drupal_dir/core/scripts/drupal install standard
  echo '🚩 Update cache'
  if [[ ! -d $cache_dir ]]; then
    mkdir -p $cache_dir
  fi
  cp -r $drupal_dir $cache_dir/$dcg_drupal_version
fi

echo '🚩 Install local DCG'
composer -d$drupal_dir config repositories.dcg path "$root_dir"
composer -d$drupal_dir update drupal/coder slevomat/coding-standard --with-all-dependencies
composer -d$drupal_dir require chi-teck/drupal-code-generator --with-all-dependencies
echo '————————————————————————————————————————————'
composer -d$drupal_dir show --ansi chi-teck/drupal-code-generator | head -n 10
echo '————————————————————————————————————————————'

echo '🚩 Run tests'
$drupal_dir/vendor/bin/phpunit -c $dcg_dir --testsuite=functional ${1:-}
