#!/usr/bin/env bash

set -o errexit
set -o nounset

cd "$(dirname "$(readlink -f $0)")"/..

echo -e "\n\e[104m Code sniffer \e[0m\n"
./vendor/bin/phpcs -ps

echo -e "\n\e[104m Psalm \e[0m\n"
./vendor/bin/psalm
