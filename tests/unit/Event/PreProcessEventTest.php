<?php declare(strict_types = 1);

namespace DrupalCodeGenerator\Tests\Unit\Event;

use DrupalCodeGenerator\Asset\AssetCollection;
use DrupalCodeGenerator\Event\PreProcessEvent;
use PHPUnit\Framework\TestCase;

/**
 * A test for pre-process event.
 */
final class PreProcessEventTest extends TestCase {

  /**
   * Test callback.
   */
  public function testPreProcessEvent(): void {
    $assets = new AssetCollection();
    $event = new PreProcessEvent($assets, 'example', FALSE, 'some/path');
    self::assertSame($assets, $event->assets);
    self::assertSame('example', $event->commandName);
    self::assertSame(FALSE, $event->isDry);
    self::assertSame('some/path', $event->destination);
  }

}
