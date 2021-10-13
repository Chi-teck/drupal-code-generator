<?php declare(strict_types=1);

namespace DrupalCodeGenerator\Command;

/**
 * Defines generator interface.
 */
interface GeneratorInterface {

  /**
   * Returns command label.
   *
   * @return string
   *   The human-readable command label.
   */
  public function getLabel(): string;

}
