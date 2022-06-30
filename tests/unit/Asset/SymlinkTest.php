<?php declare(strict_types=1);

namespace DrupalCodeGenerator\Tests\Unit\Asset;

use DrupalCodeGenerator\Asset\Asset;
use DrupalCodeGenerator\Asset\Symlink;
use DrupalCodeGenerator\Tests\Unit\BaseTestCase;

/**
 * Tests symlink asset.
 */
final class SymlinkTest extends BaseTestCase {

  /**
   * Test callback.
   */
  public function testGettersAndSetters(): void {
    $symlink = new Symlink('foo', 'foo.link');

    self::assertSame('foo', $symlink->getPath());
    self::assertSame(0644, $symlink->getMode());

    $symlink = Symlink::create('foo', 'foo-{bar}.link')->vars(['bar' => 'example']);
    self::assertSame('foo-example.link', $symlink->getTarget());

    self::assertInstanceOf(Asset::class, $symlink);
  }

}
