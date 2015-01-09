<?php

/**
 * @file
 * Drush integration for Example module.
 */

/**
 * Implements hook_drush_help().
 */
function example_drush_help($section) {
  switch ($section) {
    case 'drush:example-test':
      $help = dt('Help text here');
      return $help;
  }
}

/**
 * Implements hook_drush_command().
 */
function example_drush_command() {

  $items['example-test'] = array(
    'description' => 'foo',
    'arguments' => array(
      'bar' => 'Argument description',
    ),
    'required-arguments' => TRUE,
    'options' => array(
      '' => 'Option description',
    ),
    'bootstrap' => DRUSH_BOOTSTRAP_DRUPAL_FULL,
    'aliases' => array('ts'),
    'examples' => array(
      'drush ts bar --' => 'It does something with argument',
    ),
  );
  return $items;
}

/**
 * Callback function for example_test command.
 */
function drush_example_test($argument) {

  $option = drush_get_option('', 'default');
  drush_print(dt('Argument value is "@argument".', array('@argument' => $argument)));
  drush_print(dt('Option value is "@option".', array('@option' => $option)));

  drush_set_error(dt('Error text here.'));
  drush_log(dt('Log text here'));

}
