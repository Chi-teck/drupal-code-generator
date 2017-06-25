#!/usr/bin/env bash

MODULE_PATH=$DRUPAL_PATH/modules/foo

cp -R $SELF_PATH/plugin/foo $MODULE_PATH

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

dcg_phpcs $MODULE_PATH

dcg_drush en foo

# @todo Run tests here.

dcg_drush pmu foo

rm -r $MODULE_PATH
