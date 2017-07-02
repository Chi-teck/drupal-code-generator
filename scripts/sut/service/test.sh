#!/usr/bin/env bash

MODULE_PATH=$DRUPAL_PATH/modules/bar

cp -R $SELF_PATH/service/bar $MODULE_PATH

# Generate services.
$DCG -d$MODULE_PATH d8:service:access-checker -a'{"name":"Bar","machine_name":"bar","applies_to":"bar","class":"BarAccessChecker"}'
$DCG -d$MODULE_PATH d8:service:breadcrumb-builder -a'{"name":"Bar","machine_name":"bar","class":"BarBreadcrumbBuilder"}'
$DCG -d$MODULE_PATH d8:service:custom -a'{"name":"Bar","machine_name":"bar", "service_name":"bar.example","class":"Example"}'

# Check code standards.
dcg_phpcs $MODULE_PATH

dcg_drush en bar
#dcg_phpunit $MODULE_PATH/tests
dcg_drush pmu bar
