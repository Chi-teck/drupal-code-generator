<?php declare(strict_types=1);

namespace DrupalCodeGenerator;

use DrupalCodeGenerator\Style\GeneratorStyleInterface;

/**
 * Interface for classes that depend on the console input and output.
 */
interface IOAwareInterface {

  /**
   * Sets the console IO.
   */
  public function io(GeneratorStyleInterface $io): GeneratorStyleInterface;

}
