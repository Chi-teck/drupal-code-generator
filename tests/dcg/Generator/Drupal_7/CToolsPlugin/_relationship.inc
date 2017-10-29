<?php

/**
 * @file
 * Example relationship plugin.
 */

/**
 * Plugin definition.
 */
$plugin = array(
  'title' => t('Example'),
  'description' => t('Some description.'),
  'required context' => new ctools_context_required(t('Term'), array('term', 'taxonomy_term')),
  'context' => 'foo_example_context',
);

/**
* Returns a new context based on an existing context.
 */
function foo_example_context($context, $conf) {

  // @TODO: Replace "node" with identifier of the context
  // this plugin is meant to provide.
  if (empty($context->data)) {
    return ctools_context_create_empty('node', NULL);
  }

  $term = clone $context->data;

  // @TODO: Replace this code with your own.
  $related_node = node_load(1);
  return ctools_context_create('node', $related_node);
}
