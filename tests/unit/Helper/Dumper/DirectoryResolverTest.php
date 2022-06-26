<?php declare(strict_types=1);

namespace DrupalCodeGenerator\Tests\Unit\Helper\Dumper;

use DrupalCodeGenerator\Asset\Directory;

/**
 * Tests resolving directory assets.
 */
final class DirectoryResolverTest extends BaseResolverTest {

  /**
   * Test callback.
   */
  public function testResolver(): void {
    $this->markTestSkipped();
    $path = $this->createDirectory('example');
    $asset = new Directory('example');

    $resolver = $this->createResolver(replace: TRUE, dry_run: FALSE);
    $resolved_asset = $resolver->resolve($asset, $path);
    self::assertNull($resolved_asset);
    $this->assertEmptyOutput();
  }

}
