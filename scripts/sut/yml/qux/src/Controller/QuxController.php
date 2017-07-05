<?php

namespace Drupal\qux\Controller;

use Drupal\Core\Controller\ControllerBase;

/**
 * Returns responses for Qux routes.
 */
class QuxController extends ControllerBase {

  /**
   * Builds the response.
   */
  public function build() {

    $build['content'] = [
      '#type' => 'item',
      '#markup' => 'It works!',
    ];

    return $build;
  }

}
