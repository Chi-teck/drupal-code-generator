<?php

/**
 * @file
 * Example access plugin.
 */

/**
 * Plugin definition.
 */
$plugin = array(
  'single' => TRUE,
  'title' => t('Example'),
  'description' => t('Some description.'),
  'required context' => new ctools_context_required(t('User'), 'user'),
  'category' => t('Custom'),
  'callback' => 'foo_example_access_check',
  'summary' => 'foo_example_access_summary',
);

/**
 * Access callback.
 */
function foo_example_access_check($conf, $context) {

  if (empty($context->data)) {
    return;
  }

  $account = clone $context->data;

  // @TODO: Check access here.
  return TRUE;
}

/**
 * Summary callback.
 */
function foo_example_access_summary($conf, $context) {
  return t('Summary placeholder');
}
