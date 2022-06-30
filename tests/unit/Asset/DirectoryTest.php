<?php declare(strict_types=1);

namespace DrupalCodeGenerator\Tests\Unit\Asset;

use DrupalCodeGenerator\Asset\Asset;
use DrupalCodeGenerator\Asset\Directory;
use DrupalCodeGenerator\Tests\Unit\BaseTestCase;

/**
 * Tests directory asset.
 */
final class DirectoryTest extends BaseTestCase {

  /**
   * Test callback.
   */
  public function testGettersAndSetters(): void {
    $directory = new Directory('foo');

    self::assertSame('foo', $directory->getPath());
    self::assertSame(0755, $directory->getMode());
    self::assertInstanceOf(Asset::class, $directory);
  }

}
