<?php

/**
 * @file
 * Example content type plugin.
 */

/**
 * Plugin definition.
 */
$plugin = array(
  'single' => TRUE,
  'title' => t('Example'),
  'description' => t('Some description.'),
  'required context' => new ctools_context_required(t('Node'), 'node'),
  'category' => t('Custom'),
  'render callback' => 'foo_example_content_type_render',
);

/**
 * Render callback.
 */
function foo_example_content_type_render($subtype, $conf, $panel_args, $context) {

  if (empty($context->data)) {
    return;
  }

  $node = clone $context->data;

  // Build pane content.
  $build = array(
    '#markup' => 'Content placeholder.',
  );

  $block = new stdClass();
  $block->module = 'foo';
  $block->title = t('Title placeholder');
  $block->content = $build;
  return $block;
}
