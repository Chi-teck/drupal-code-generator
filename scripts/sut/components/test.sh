#!/usr/bin/env bash

MODULE_PATH=$DRUPAL_PATH/modules/foo

cp -R $SELF_PATH/components/foo $MODULE_PATH

# Info file.
$DCG -d$MODULE_PATH d8:yml:module-info -a'{"name":"Foo","machine_name":"foo","description":"DCG components","package":"DCG","version":"","configure":"","dependencies":""}'

# Generate forms.
$DCG -d$MODULE_PATH d8:form:simple -a'{"name":"Foo","machine_name":"foo","class":"SimpleForm","form_id":"foo_simple"}'
$DCG -d$MODULE_PATH d8:form:config -a'{"name":"Foo","machine_name":"foo","class":"SettingsForm","form_id":"foo_settings"}'
$DCG -d$MODULE_PATH d8:form:confirm -a'{"name":"Foo","machine_name":"foo","class":"ConfirmForm","form_id":"foo_confirm"}'

# Generate plugins.
$DCG -d$MODULE_PATH d8:plugin:field:formatter -a'{"name":"Foo","machine_name":"foo","plugin_label":"Example","plugin_id":"example"}'
$DCG -d$MODULE_PATH d8:plugin:field:type -a'{"name":"Foo","machine_name":"foo","plugin_label":"Example","plugin_id":"example"}'
$DCG -d$MODULE_PATH d8:plugin:field:widget -a'{"name":"Foo","machine_name":"foo","plugin_label":"Example","plugin_id":"example"}'

$DCG -d$MODULE_PATH d8:plugin:views:argument-default -a'{"name":"Foo","machine_name":"foo","plugin_label":"Example","plugin_id":"example"}'
$DCG -d$MODULE_PATH d8:plugin:views:field -a'{"name":"Foo","machine_name":"foo","plugin_label":"Example","plugin_id":"example"}'
$DCG -d$MODULE_PATH d8:plugin:views:style -a'{"name":"Foo","machine_name":"foo","plugin_label":"Example","plugin_id":"example"}'

$DCG -d$MODULE_PATH d8:plugin:action -a'{"name":"Foo","machine_name":"foo","plugin_label":"Example","plugin_id":"example","category":"DCG","configurable":true}'
$DCG -d$MODULE_PATH d8:plugin:block -a'{"name":"Foo","machine_name":"foo","plugin_label":"Example","plugin_id":"example","category":"DCG"}'
$DCG -d$MODULE_PATH d8:plugin:condition -a'{"name":"Foo","machine_name":"foo","plugin_label":"Example","plugin_id":"example"}'
$DCG -d$MODULE_PATH d8:plugin:filter -a'{"name":"Foo","machine_name":"foo","plugin_label":"Example","plugin_id":"example"}'
$DCG -d$MODULE_PATH d8:plugin:menu-link -a'{"name":"Foo","machine_name":"foo","class":"FooExample"}'
$DCG -d$MODULE_PATH d8:plugin:rest-resource -a'{"name":"Foo","machine_name":"foo","plugin_label":"Example","plugin_id":"example"}'

# Check code standards.
dcg_phpcs --exclude=DrupalPractice.Yaml.RoutingAccess $MODULE_PATH

dcg_drush en foo
dcg_phpunit $MODULE_PATH/tests
dcg_drush pmu foo

rm -r $MODULE_PATH
