#!/usr/bin/env bash

set -o errexit
set -o nounset

cd "$(dirname "$(readlink -f $0)")"/..

echo -e "\n\e[104m Code sniffer \e[0m\n"
./vendor/bin/phpcs -ps

# @todo  Remove this once we drop support for Drupal 10.
drupal_version=$(composer show drupal/core | sed -n '/versions/s/^[^0-9]\+\([^,]\+\).*$/\1/p')
if [[ $drupal_version =~ ^11 ]]; then
  echo -e "\n\e[104m Psalm \e[0m\n"
  ./vendor/bin/psalm
fi
