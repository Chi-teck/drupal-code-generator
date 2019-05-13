<?php

namespace DrupalCodeGenerator\Command;

/**
 * Defines generator interface.
 */
interface GeneratorInterface {

  /**
   * Returns command label.
   *
   * @return string|null
   *   A label suitable for navigation command.
   */
  public function getLabel() :?string;

  /**
   * Sets working directory.
   *
   * @param string $directory
   *   The working directory.
   */
  public function setDirectory(string $directory);

  /**
   * Returns current working directory.
   *
   * @return string|null
   *   The directory.
   */
  public function getDirectory() :string;

}
