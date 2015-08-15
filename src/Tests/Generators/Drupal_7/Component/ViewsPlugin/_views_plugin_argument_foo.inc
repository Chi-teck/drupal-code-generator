<?php

/**
 * @file
 * Contains the Foo argument default plugin.
 *
 * @DCG: This file needs to be referenced in example.info with the files[] directive.
 */

/**
 * @DCG: Describe you plugin here.
 */
class views_plugin_argument_foo extends views_plugin_argument_default {

  /**
   * {@inheritdoc}
   *
   * @DCG: Optional.
   */
  function option_definition() {
    $options = parent::option_definition();
    $options['example_option'] = array('default' => 'Bar');
    return $options;
  }

  /**
   * {@inheritdoc}
   *
   * @DCG: Optional.
   */
  function options_form(&$form, &$form_state) {
    $form['example_option'] = array(
      '#type' => 'textfield',
      '#title' => t('Some example option.'),
      '#default_value' => $this->options['example_option'],
    );
  }

  /**
   * {@inheritdoc}
   *
   * @DCG: Optional.
   */
  function options_validate(&$form, &$form_state) {
    if ($form_state['values']['options']['argument_default']['foo']['example_option'] > 10) {
      form_error($form['example_option'], t('The value is not correct.'));
    }
  }

  /**
   * {@inheritdoc}
   *
   * @DCG: Optional.
   */
  function options_submit(&$form, &$form_state, &$options) {
    // @DCG: It is just for example.
    // @DCG: You most likely will not override this method.
    $options['example_option'] = 10 * $form_state['values']['options']['argument_default']['foo']['example_option'];
  }

  /**
   * {@inheritdoc}
   */
  function get_argument() {

    /**
     * @DCG: {
     * Here is the place where you should create a default argument for the
     * contextual filter. The source of this argument depends on your needs.
     * For example, you can extract the value from the URL or fetch it from
     * some fields of the current viewed entity.
     * @DCG: }
     */

    // @DCG: For now lets use example option as an argument.
    $argument = $this->options['example_option'];

    return $argument;
  }
}

/**
 * Implements hook_views_plugins().
 *
 * @DCG: IMPORTANT. This hook must be moved to the example.views.inc file.
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
