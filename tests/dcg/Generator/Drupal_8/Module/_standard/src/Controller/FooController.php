<?php

namespace Drupal\foo\Controller;

use Drupal\Core\Controller\ControllerBase;

/**
 * Returns responses for Foo routes.
 */
class FooController extends ControllerBase {

  /**
   * Builds the response.
   */
  public function build() {

    $build['content'] = [
      '#type' => 'item',
      '#markup' => $this->t('It works!'),
    ];

    return $build;
  }

}
