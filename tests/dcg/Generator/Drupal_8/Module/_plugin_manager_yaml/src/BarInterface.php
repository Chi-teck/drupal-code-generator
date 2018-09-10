<?php

namespace Drupal\foo;

/**
 * Interface for bar plugins.
 */
interface BarInterface {

  /**
   * Returns the translated plugin label.
   *
   * @return string
   *   The translated title.
   */
  public function label();

}
