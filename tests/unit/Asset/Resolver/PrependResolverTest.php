<?php declare(strict_types = 1);

namespace DrupalCodeGenerator\Tests\Unit\Asset\Resolver;

use DrupalCodeGenerator\Asset\Directory;
use DrupalCodeGenerator\Asset\File;
use DrupalCodeGenerator\Asset\Resolver\PrependResolver;

/**
 * Tests PrependResolver.
 */
final class PrependResolverTest extends BaseResolverTest {

  /**
   * Test callback.
   */
  public function testPrepend(): void {
    $resolver = new PrependResolver();

    $path = $this->createFile('foo.txt', 'Existing content.');
    $asset = File::create('foo.txt')->content('New content.');
    $resolved_asset = $resolver->resolve($asset, $path);

    self::assertNotSame($asset, $resolved_asset);

    $expected_resolved_asset = File::create('foo.txt')->content("New content.\nExisting content.");
    self::assertEquals($expected_resolved_asset, $resolved_asset);

    $this->assertEmptyOutput();
  }

  /**
   * Test callback.
   */
  public function testWrongAssetType(): void {
    $resolver = new PrependResolver();
    self::expectExceptionObject(new \InvalidArgumentException('Wrong asset type.'));
    $resolver->resolve(new Directory('example'), 'example');
  }

}
