<?php

/**
 * @file
 * Provide views data and handlers for Example module.
 */

/**
 * Implements hook_views_plugins().
 */
function example_views_plugins() {
  return array(
    'module' => 'example',
    'argument default' => array(
      'foo' => array(
        'title' => t('Foo'),
        'handler' => 'views_plugin_argument_foo',
      ),
    ),
  );
}
