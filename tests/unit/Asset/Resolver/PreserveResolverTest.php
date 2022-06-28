<?php declare(strict_types=1);

namespace DrupalCodeGenerator\Tests\Unit\Asset\Resolver;

use DrupalCodeGenerator\Asset\File;
use DrupalCodeGenerator\Asset\Resolver\PreserveResolver;

/**
 * Tests PreserveResolver.
 */
final class PreserveResolverTest extends BaseResolverTest {

  /**
   * Test callback.
   */
  public function testPreserve(): void {
    $resolver = new PreserveResolver();

    $asset = File::create('foo.txt')->content('Example');
    $resolved_asset = $resolver->resolve($asset, 'foo.txt');
    self::assertNotSame($asset, $resolved_asset);

    $expected_resolved_asset = File::create('foo.txt')->content('Example')->setVirtual(TRUE);
    self::assertEquals($expected_resolved_asset, $resolved_asset);

    $this->assertEmptyOutput();
  }

}
