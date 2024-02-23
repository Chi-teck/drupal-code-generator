<?php

declare(strict_types=1);

namespace DrupalCodeGenerator\Helper\Dumper;

use DrupalCodeGenerator\Asset\AssetCollection;

/**
 * An interface for asset dumpers.
 */
interface DumperInterface {

  /**
   * Dumps the generated code to file system or stdout.
   */
  public function dump(AssetCollection $assets, string $destination): AssetCollection;

}
