#!/usr/bin/env bash
# shellcheck disable=SC2086

set -o errexit
set -o nounset

cd "$(dirname "$(readlink -f $0)")"/..

echo -e "\e[104m PHPUnit \e[0m\n"
./vendor/bin/phpunit

echo -e "\n\e[104m Code sniffer \e[0m\n"
./vendor/bin/phpcs -p

