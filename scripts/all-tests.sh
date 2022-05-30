#!/usr/bin/env bash

set -Eeuo pipefail

SCRIPTS_DIR=$(dirname "$(readlink -f "$0")");

function dcg_label {
  echo -e "\n\e[30;46m ✻ $* ✻ \e[0m\n"
}

dcg_label 'Linter'
"$SCRIPTS_DIR"/lint.sh
dcg_label 'Unit tests'
"$SCRIPTS_DIR"/unit-tests.sh
dcg_label 'Functional tests'
"$SCRIPTS_DIR"/functional-tests.sh
dcg_label 'SUT tests'
"$SCRIPTS_DIR"/sut-tests.sh
