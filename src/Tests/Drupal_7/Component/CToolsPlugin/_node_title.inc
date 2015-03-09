<?php

/**
 * @file
 * Node title content type plugin.
 */

/**
 * Plugin definition.
 */
$plugin = array(
  'single' => TRUE,
  'title' => t('Node title'),
  'description' => t('Some description'),
  'required context' => new ctools_context_required(t('Node'), 'node'),
  'category' => t('Custom'),
  'render callback' => 'node_title_content_type_render',
);

/**
 * Render callback.
 */
function node_title_content_type_render($subtype, $conf, $panel_args, $context) {

  if (empty($context->data)) {
    return;
  }

  $node = clone $context->data;

  // Build pane content.
  $build = array(
    '#markup' => check_plain($node->title),
  );

  $block = new stdClass();
  $block->module = 'example';
  $block->title = t('Pane title');
  $block->content = $build;
  return $block;
}
