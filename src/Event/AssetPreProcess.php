<?php

declare(strict_types=1);

namespace DrupalCodeGenerator\Event;

use DrupalCodeGenerator\Asset\AssetCollection;

/**
 * Fired before dumping assets.
 */
final class AssetPreProcess {

  /**
   * Constructs the event object.
   */
  public function __construct(
    public AssetCollection $assets,
    public string $destination,
    public readonly string $commandName,
    public readonly bool $isDry,
  ) {}

}
