<?php

/**
 * @file
 * Theme settings form for Foo theme.
 */

/**
 * Implements hook_form_system_theme_settings_alter().
 */
function foo_form_system_theme_settings_alter(&$form, &$form_state) {

  $form['foo'] = [
    '#type' => 'details',
    '#title' => t('Foo'),
    '#open' => TRUE,
  ];

  $form['foo']['font_size'] = [
    '#type' => 'number',
    '#title' => t('Font size'),
    '#min' => 12,
    '#max' => 18,
    '#default_value' => theme_get_setting('font_size'),
  ];

}
