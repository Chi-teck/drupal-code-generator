<?php declare(strict_types=1);

namespace DrupalCodeGenerator\Command;

/**
 * Defines generator interface.
 */
interface LabelInterface {

  /**
   * Returns command label.
   *
   * @return string|null
   *   The human-readable command label.
   */
  public function getLabel(): ?string;

}
