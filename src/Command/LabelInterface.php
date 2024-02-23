<?php

declare(strict_types=1);

namespace DrupalCodeGenerator\Command;

/**
 * Interface for generators that provide human-readable label.
 */
interface LabelInterface {

  /**
   * Returns the human-readable command label.
   */
  public function getLabel(): ?string;

}
