<?php

/**
 * @file
 * Contains yo-yo drush command.
 */

/**
 * Implements hook_drush_help().
 */
function yo_yo_drush_help($section) {
  switch ($section) {
    case 'drush:yo-yo':
      $help = dt('Help text here.');
      return $help;
  }
}

/**
 * Implements hook_drush_command().
 */
function yo_yo_drush_command() {

  $items['yo-yo'] = [
    'description' => 'Description.',
    'arguments' => [
      'foo' => 'Argument description',
    ],
    'required-arguments' => TRUE,
    'options' => [
      'bar' => 'Option description',
    ],
    'bootstrap' => DRUSH_BOOTSTRAP_DRUPAL_FULL,
    'aliases' => ['yy'],
    'examples' => [
      'drush yy foo --bar' => 'It does something with this argument',
    ],
  ];

  return $items;
}

/**
 * Callback function for yo-yo command.
 */
function drush_yo_yo($argument) {

  $option = drush_get_option('bar', 'default');
  drush_print(dt('Argument value is "@argument".', ['@argument' => $argument]));
  drush_print(dt('Option value is "@option".', ['@option' => $option]));

  drush_set_error(dt('Error text here.'));
  drush_log(dt('Log text here'));

}
