<?php declare(strict_types = 1);

namespace DrupalCodeGenerator\Helper\Processor;

use DrupalCodeGenerator\Asset\AssetCollection;
use Symfony\Component\Console\Helper\Helper;

/**
 * Stub processor.
 */
final class NullProcessor extends Helper implements ProcessorInterface {

  /**
   * {@inheritdoc}
   */
  public function getName(): string {
    return 'processor';
  }

  /**
   * {@inheritdoc}
   */
  public function preProcess(AssetCollection $assets): void {
    // Intentionally empty.
  }

  /**
   * {@inheritdoc}
   */
  public function postProcess(AssetCollection $assets, string $destination): void {
    // Intentionally empty.
  }

}
