<?php

/**
 * @file
 * Drush integration for Foo module.
 */

/**
 * Implements hook_drush_command().
 */
function foo_drush_command() {
  $items['foo-list'] = [
    'description' => 'Show a list of available foos.',
  ];
  return $items;
}

/**
 * Callback function for foo-list command.
 */
function drush_foo_list() {
  $plugin_manager = Drupal::service('plugin.manager.foo');

  $rows[] = [
    'ID',
    'Label',
    'Description',
    'Method 1',
    'Method 2',
    'Method 3',
  ];

  foreach ($plugin_manager->getDefinitions() as $definition) {
    $foo = $plugin_manager->createInstance($definition['id']);
    $rows[] = [
      $definition['id'],
      $definition['label'],
      $definition['description'],
      $foo->method1(),
      $foo->method2(),
      $foo->method3(),
    ];
  }

  drush_print_table($rows);
}
