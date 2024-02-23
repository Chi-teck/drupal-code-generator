<?php

declare(strict_types=1);

namespace DrupalCodeGenerator\Tests\Unit\Asset\Resolver;

use DrupalCodeGenerator\Asset\Directory;
use DrupalCodeGenerator\Asset\File;
use DrupalCodeGenerator\Asset\Resolver\AppendResolver;

/**
 * Tests AppendResolver.
 */
final class AppendResolverTest extends BaseResolverTest {

  /**
   * Test callback.
   */
  public function testWithoutHeader(): void {
    $resolver = new AppendResolver();

    $path = $this->createFile('foo.txt', 'Existing content.');
    $asset = File::create('foo.txt')->content('New content.');
    $resolved_asset = $resolver->resolve($asset, $path);

    self::assertNotSame($asset, $resolved_asset);

    $expected_resolved_asset = File::create('foo.txt')
      ->content("Existing content.\nNew content.");
    self::assertEquals($expected_resolved_asset, $resolved_asset);

    $this->assertEmptyOutput();
  }

  /**
   * Test callback.
   */
  public function testWithHeader(): void {
    $resolver = new AppendResolver(1);

    $path = $this->createFile('bar.txt', 'Existing content.');
    $asset = File::create('bar.txt')->content("Header\nNew content.");
    $resolved_asset = $resolver->resolve($asset, $path);

    self::assertNotSame($asset, $resolved_asset);

    $expected_resolved_asset = File::create('bar.txt')
      ->content("Existing content.\nNew content.");
    self::assertEquals($expected_resolved_asset, $resolved_asset);
    $this->assertEmptyOutput();

    self::expectExceptionObject(new \InvalidArgumentException('Wrong asset type.'));
    $resolver->resolve(new Directory('example'), 'example');
  }

  /**
   * Test callback.
   */
  public function testWrongAssetType(): void {
    $resolver = new AppendResolver();
    self::expectExceptionObject(new \InvalidArgumentException('Wrong asset type.'));
    $resolver->resolve(new Directory('example'), 'example');
  }

}
