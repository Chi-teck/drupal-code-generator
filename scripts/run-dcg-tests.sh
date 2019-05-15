#!/usr/bin/env bash

set -e

cd $(dirname $(readlink -f $0))'/..'

echo -e "\e[104m ◂ PHPUnit ▸ \e[0m"
./vendor/bin/phpunit

echo -e "\n\e[104m ◂ Code sniffer ▸ \e[0m"
./vendor/bin/phpcs -p

echo -e "\n\e[104m ◂ PHP Static Analysis ▸ \e[0m"
./vendor/bin/phpstan analyze --ansi 2> /dev/null

echo -e "\e[104m ◂ Twig linter ▸ \e[0m"
./vendor/bin/twigcs ./templates
