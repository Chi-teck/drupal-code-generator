#!/usr/bin/env bash

MODULE_PATH=$DRUPAL_PATH/modules/qux

cp -R $SELF_PATH/yml/qux $MODULE_PATH

# Generate YML files.
$DCG -d$MODULE_PATH d8:yml:action-links -a'{"machine_name":"qux"}'
$DCG -d$MODULE_PATH d8:yml:menu-links -a'{"machine_name":"qux"}'
$DCG -d$MODULE_PATH d8:yml:module-info -a'{"name":"Qux","machine_name":"qux","description":"Helper module for testing YML generators.", "package": "DCG","configure":"", "dependencies":""}'
$DCG -d$MODULE_PATH d8:yml:module-libraries -a'{"name":"Qux","machine_name":"qux"}'
$DCG -d$MODULE_PATH d8:yml:permissions -a'{"machine_name":"qux"}'
$DCG -d$MODULE_PATH d8:yml:routing -a'{"name":"Qux","machine_name":"qux"}'
$DCG -d$MODULE_PATH d8:yml:services -a'{"name":"Qux","machine_name":"qux"}'
$DCG -d$MODULE_PATH d8:yml:task-links -a'{"machine_name":"qux"}'

# Check code standards.
dcg_phpcs $MODULE_PATH

dcg_drush en qux
#dcg_phpunit $MODULE_PATH/tests
dcg_drush pmu qux
