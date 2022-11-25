<?php declare(strict_types = 1);

namespace DrupalCodeGenerator\InputOutput;

/**
 * Defines a trait to set and get console IO.
 */
trait IOAwareTrait {

  private ?IO $io = NULL;

  /**
   * {@inheritdoc}
   */
  public function io(?IO $io = NULL): IO {
    if ($io) {
      $this->io = $io;
    }
    elseif (!$this->io) {
      throw new \LogicException('IO is not initialized yet.');
    }
    return $this->io;
  }

}
