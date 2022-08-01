<?php declare(strict_types = 1);

namespace DrupalCodeGenerator\Helper\Processor;

use DrupalCodeGenerator\Asset\AssetCollection;

/**
 * Processor interface.
 */
interface ProcessorInterface {

  /**
   * Assets to be dumped.
   */
  public function preProcess(AssetCollection $assets): void;

  /**
   * Dumped assets.
   */
  public function postProcess(AssetCollection $assets, string $destination): void;

}
