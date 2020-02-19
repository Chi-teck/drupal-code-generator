#!/usr/bin/env bash

set -o errexit
set -o nounset

composer install --no-dev

if ! command -v box > /dev/null; then
  echo 'ERROR: box tool is not installed' >&2
  exit 1
fi

box build -v
