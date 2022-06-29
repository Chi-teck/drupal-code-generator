<?php declare(strict_types=1);

namespace DrupalCodeGenerator\InputOutput;

/**
 * Defines a trait to set and get console IO.
 */
trait IOAwareTrait {

  private IO $io;

  /**
   * {@inheritdoc}
   */
  public function io(?IO $io = NULL): IO {
    if ($io) {
      $this->io = $io;
    }
    return $this->io;
  }

}
