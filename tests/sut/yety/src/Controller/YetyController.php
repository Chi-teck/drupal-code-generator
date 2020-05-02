<?php

namespace Drupal\yety\Controller;

use Drupal\Core\Controller\ControllerBase;

/**
 * Controller for generated routing.yml file.
 */
final class YetyController extends ControllerBase {

  /**
   * Builds the response.
   */
  public function build(): array {

    $build['content'] = [
      '#type' => 'item',
      '#markup' => 'It works!',
    ];

    return $build;
  }

}
