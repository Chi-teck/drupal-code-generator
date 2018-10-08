<?php

/**
 * @file
 * Page callbacks for Example module.
 */

/**
 * Menu callback; presents main Example page.
 */
function example_main_page() {

  $build['content']['#markup'] = 'It works!';
  $build['#attached']['js'][] = drupal_get_path('module', 'example') . '/example.js';

  return $build;
}
