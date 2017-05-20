<?php

namespace DrupalCodeGenerator\Commands;

use Symfony\Component\Console\Input\InputInterface;

/**
 * Defines generator interface.
 */
interface GeneratorInterface {

  /**
   * Getter for dynamic properties.
   */
  public function getAssets();

  /**
   * Sets working directory.
   *
   * @param string $directory
   *   The working directory.
   */
  public function setDirectory($directory);

  /**
   * Returns current working directory.
   *
   * @param \Symfony\Component\Console\Input\InputInterface $input
   *   (Optional) Input instance.
   */
  public function getDirectory(InputInterface $input);

}
