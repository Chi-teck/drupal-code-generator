#!/usr/bin/env bash

set -e
DCG_DIR=$(dirname $(readlink -f $0))'/..'

echo -e "\e[104m ◂ PHPUnit ▸ \e[0m"
$DCG_DIR/vendor/bin/phpunit -c $DCG_DIR

echo -e "\n\e[104m ◂ Code sniffer ▸ \e[0m"
$DCG_DIR/vendor/bin/phpcs -p --standard=$DCG_DIR/phpcs.xml

echo -e "\e[104m ◂ Twig linter ▸ \e[0m"
$DCG_DIR/vendor/bin/twigcs $DCG_DIR/templates
