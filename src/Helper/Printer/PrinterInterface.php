<?php declare(strict_types = 1);

namespace DrupalCodeGenerator\Helper\Printer;

use DrupalCodeGenerator\Asset\AssetCollection;

/**
 * An interface for asset printers.
 */
interface PrinterInterface {

  /**
   * Prints summary.
   */
  public function printAssets(AssetCollection $assets, string $base_path = ''): void;

}
