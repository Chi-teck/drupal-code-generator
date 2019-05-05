<?php

namespace DrupalCodeGenerator;

use Symfony\Component\Console\Output\OutputInterface;

/**
 * Interface for classes that depend on the console output.
 */
interface OutputAwareInterface {

  /**
   * Sets the console output.
   */
  public function setOutput(OutputInterface $output) :void;

}
