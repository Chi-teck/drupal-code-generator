#!/usr/bin/env bash

MODULE_PATH=$DRUPAL_PATH/modules/foo

cp -R $SELF_PATH/form/foo $MODULE_PATH

$DCG -d$MODULE_PATH d8:form:simple -a'{"name":"Foo","machine_name":"foo","class":"SimpleForm","form_id":"foo_simple"}'
$DCG -d$MODULE_PATH d8:form:config -a'{"name":"Foo","machine_name":"foo","class":"SettingsForm","form_id":"foo_settings"}'
$DCG -d$MODULE_PATH d8:form:confirm -a'{"name":"Foo","machine_name":"foo","class":"ConfirmForm","form_id":"foo_confirm"}'

dcg_phpcs --exclude=DrupalPractice.Yaml.RoutingAccess $MODULE_PATH

dcg_drush en foo

dcg_phpunit $MODULE_PATH/tests

dcg_drush pmu foo

rm -r $MODULE_PATH
