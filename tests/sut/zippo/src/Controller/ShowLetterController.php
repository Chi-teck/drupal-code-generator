<?php declare(strict_types = 1);

namespace Drupal\zippo\Controller;

use Drupal\Core\Controller\ControllerBase;

/**
 * A controller for testing param converter.
 */
final class ShowLetterController extends ControllerBase {

  /**
   * Builds the response.
   */
  public function __invoke(string $letter): array {
    return ['#markup' => $letter];
  }

}
