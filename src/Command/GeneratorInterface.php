<?php declare(strict_types=1);

namespace DrupalCodeGenerator\Command;

/**
 * Defines generator interface.
 */
interface GeneratorInterface {

  /**
   * Returns the human-readable command label.
   */
  public function getLabel(): string;

}
