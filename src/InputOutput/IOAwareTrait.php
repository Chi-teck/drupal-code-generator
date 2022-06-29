<?php declare(strict_types=1);

namespace DrupalCodeGenerator\InputOutput;

/**
 * Defines a trait to set console IO.
 */
trait IOAwareTrait {

  /**
   * Console input.
   */
  protected IO $io;

  /**
   * Sets the console IO.
   */
  public function io(?IO $io = NULL): IO {
    if ($io) {
      $this->io = $io;
    }
    return $this->io;
  }

}
