#!/usr/bin/env bash

set -Eeuo pipefail

scripts_dir=$(dirname "$(readlink -f "$0")");

function dcg_label {
  echo -e "\n\e[30;46m ✻ $* ✻ \e[0m\n"
}

dcg_label 'Linter'
"$scripts_dir"/lint.sh
dcg_label 'Unit tests'
"$scripts_dir"/unit-tests.sh
dcg_label 'Functional tests'
"$scripts_dir"/functional-tests.sh
dcg_label 'SUT tests'
"$scripts_dir"/sut-tests.sh
