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

}
