<?php

declare(strict_types=1);

namespace Drupal\foo;

/**
 * Interface for bar plugins.
 */
interface BarInterface {

  /**
   * Returns the translated plugin label.
   */
  public function label(): string;

}
