<?php

namespace DrupalCodeGenerator;

use Symfony\Component\Console\Input\InputInterface;

/**
 * Interface for classes that depend on the console input.
 */
interface InputAwareInterface {

  /**
   * Sets the console input.
   */
  public function setInput(InputInterface $input) :void;

}
