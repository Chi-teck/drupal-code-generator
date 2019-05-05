<?php

namespace DrupalCodeGenerator;

use Symfony\Component\Console\Input\InputInterface;

/**
 * Defines a trait to set console input.
 */
trait InputAwareTrait {

  /**
   * Console input.
   *
   * @var \Symfony\Component\Console\Input\InputInterface
   */
  protected $input;

  /**
   * Sets the console input.
   */
  public function setInput(InputInterface $input) :void {
    $this->input = $input;
  }

}
