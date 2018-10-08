<?php

/**
 * @file
 * Admin page callbacks for the Example module.
 */

/**
 * Form constructor for the main Example administration form.
 */
function example_settings_form($form, &$form_state) {

  $form['example_setting_1'] = array(
    '#type' => 'textfield',
    '#title' => t('Setting 1'),
    '#default_value' => variable_get('example_setting_1'),
  );
  $form['example_setting_2'] = array(
    '#type' => 'select',
    '#title' => t('Setting 1'),
    '#options' => array(t('Option 1'), t('Option 2'), t('Option 3')),
    '#default_value' => variable_get('example_setting_2'),
  );
  $form['example_setting_3'] = array(
    '#type' => 'checkbox',
    '#title' => t('Setting 3'),
    '#default_value' => variable_get('example_setting_3'),
  );

  return system_settings_form($form);
}
