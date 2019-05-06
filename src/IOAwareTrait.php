<?php

namespace DrupalCodeGenerator;

use DrupalCodeGenerator\Style\GeneratorStyleInterface;

/**
 * Defines a trait to set console IO.
 */
trait IOAwareTrait {

  /**
   * Console input.
   *
   * @var \DrupalCodeGenerator\Style\GeneratorStyleInterface
   */
  protected $io;

  /**
   * Sets the console IO.
   */
  public function io(GeneratorStyleInterface $io = NULL) :GeneratorStyleInterface {
    if ($io) {
      $this->io = $io;
    }
    return $this->io;
  }

}
