<?php

namespace DrupalCodeGenerator;

use Symfony\Component\Console\Output\OutputInterface;

/**
 * Defines a trait to set console output.
 */
trait OutputAwareTrait {

  /**
   * Console output.
   *
   * @var \Symfony\Component\Console\Output\OutputInterface
   */
  protected $output;

  /**
   * Sets the console input.
   */
  public function setOutput(OutputInterface $output) :void {
    $this->output = $output;
  }

}
