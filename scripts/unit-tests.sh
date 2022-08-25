#!/usr/bin/env bash

set -o errexit
set -o nounset

cd "$(dirname "$(readlink -f $0)")"/..

./vendor/bin/phpunit --testsuite=unit ${1:-}
