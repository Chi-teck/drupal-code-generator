<?php declare(strict_types = 1);

namespace DrupalCodeGenerator\Tests\Unit\Event;

use DrupalCodeGenerator\Asset\AssetCollection;
use DrupalCodeGenerator\Event\PostProcessEvent;
use PHPUnit\Framework\TestCase;

/**
 * A test for post-process event.
 */
final class PostProcessEventTest extends TestCase {

  /**
   * Test callback.
   */
  public function testPreProcessEvent(): void {
    $assets = new AssetCollection();
    $event = new PostProcessEvent($assets, 'some/path', 'example', FALSE);
    self::assertSame($assets, $event->assets);
    self::assertSame('some/path', $event->destination);
    self::assertSame('example', $event->commandName);
    self::assertSame(FALSE, $event->isDry);
  }

}
