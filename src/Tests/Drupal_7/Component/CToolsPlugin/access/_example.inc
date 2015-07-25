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
  'description' => t('Some description'),
  'required context' => new ctools_context_required(t('User'), 'user'),
  'category' => t('Custom'),
  'callback' => 'example_access_check',
  'summary' => 'example_access_summary',
);

/**
 * Render callback.
 */
function example_access_check($conf, $context) {

  if (empty($context->data)) {
    return;
  }

  $account = clone $context->data;

  // @TODO: Check access here.
  return TRUE;
}

/**
 * Provide a summary description based upon the checked conditions.
 */
function example_access_summary($conf, $context) {
  return t('Summary placeholder');
}
