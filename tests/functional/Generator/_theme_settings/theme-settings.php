<?php

declare(strict_types=1);

/**
 * @file
 * Theme settings form for Foo theme.
 */

use Drupal\Core\Form\FormState;

/**
 * Implements hook_form_system_theme_settings_alter().
 */
function foo_form_system_theme_settings_alter(array &$form, FormState $form_state): void {

  $form['foo'] = [
    '#type' => 'details',
    '#title' => t('Foo'),
    '#open' => TRUE,
  ];

  $form['foo']['example'] = [
    '#type' => 'textfield',
    '#title' => t('Example'),
    '#default_value' => theme_get_setting('example'),
  ];

}
