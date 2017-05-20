<?php

namespace DrupalCodeGenerator\Commands;

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
   */
  public function getDirectory();

}
