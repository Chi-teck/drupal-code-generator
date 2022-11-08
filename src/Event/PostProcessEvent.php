<?php declare(strict_types = 1);

namespace DrupalCodeGenerator\Event;

use DrupalCodeGenerator\Asset\AssetCollection;
use DrupalCodeGenerator\Helper\Dumper\DumperInterface;
use Symfony\Component\Console\Command\Command;

/**
 * Fired when altering dumped assets.
 */
final class PostProcessEvent {

  use StoppableEventTrait;

  /**
   * Constructs the event object.
   */
  public function __construct(
    public readonly AssetCollection $assets,
    public readonly DumperInterface $dumper,
    public readonly string $destination,
    public readonly Command $generator,
  ) {}

}
