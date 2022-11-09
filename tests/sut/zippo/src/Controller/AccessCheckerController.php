<?php declare(strict_types = 1);

namespace Drupal\zippo\Controller;

use Drupal\Core\Controller\ControllerBase;

/**
 * A controller for testing access checker.
 */
final class AccessCheckerController extends ControllerBase {

  /**
   * Builds the response.
   */
  public function __invoke(): array {
    return ['#markup' => 'It works!'];
  }

}
