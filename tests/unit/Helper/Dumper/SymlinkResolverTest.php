<?php declare(strict_types=1);

namespace DrupalCodeGenerator\Tests\Unit\Helper\Dumper;

use DrupalCodeGenerator\Asset\Symlink;

/**
 * Tests resolving symlink assets.
 */
final class SymlinkResolverTest extends BaseResolverTest {

  /**
   * Test callback.
   */
  public function testReplace(): void {
    $this->markTestSkipped();
    $path = $this->createSymlink('example', 'example_target');
    $asset = new Symlink('example', 'example_target');

    // -- Replace = Yes.
    $resolver = $this->createResolver(replace: TRUE, dry_run: FALSE);
    $resolved_asset = $resolver->resolve($asset, $path);
    $expected_resolved_asset = new Symlink('example', 'example_target');
    self::assertEquals($expected_resolved_asset, $resolved_asset);
    $this->assertEmptyOutput();

    // -- Replace: No.
    $resolver = $this->createResolver(replace: FALSE, dry_run: FALSE);
    $resolved_asset = $resolver->resolve($asset, $path);
    self::assertNull($resolved_asset);
    $this->assertEmptyOutput();

    // -- Replace: Confirm.
    $resolver = $this->createResolver(replace: NULL, dry_run: FALSE);

    $this->setStream("Yes\n");
    $resolved_asset = $resolver->resolve($asset, $path);
    $expected_resolved_asset = new Symlink('example', 'example_target');
    self::assertEquals($expected_resolved_asset, $resolved_asset);
    $expected_output = <<< 'TEXT'

     The symlink %directory%/example already exists. Would you like to replace it? [Yes]:
     ➤ 
    TEXT;
    $this->assertOutput($expected_output);

    $this->setStream("No\n");
    $resolved_asset = $resolver->resolve($asset, $path);
    self::assertNull($resolved_asset);
    $expected_output = <<< 'TEXT'

     The symlink %directory%/example already exists. Would you like to replace it? [Yes]:
     ➤ 
    TEXT;
    $this->assertOutput($expected_output);
  }

  /**
   * Test callback.
   */
  public function testSkip(): void {
    $this->markTestSkipped();
    $path = $this->createSymlink('example', 'example_target');
    $asset = (new Symlink('example', 'example_target'))->preserveIfExists();

    // -- Replace: Yes.
    $resolver = $this->createResolver(replace: TRUE, dry_run: FALSE);
    $resolved_asset = $resolver->resolve($asset, $path);
    self::assertNull($resolved_asset);
    $this->assertEmptyOutput();

    // -- Replace: No.
    $resolver = $this->createResolver(replace: FALSE, dry_run: FALSE);
    $resolved_asset = $resolver->resolve($asset, $path);
    self::assertNull($resolved_asset);
    $this->assertEmptyOutput();

    // -- Replace: Confirm.
    $resolver = $this->createResolver(replace: NULL, dry_run: FALSE);

    $resolved_asset = $resolver->resolve($asset, $path);
    self::assertNull($resolved_asset);
    $this->assertEmptyOutput();

    $resolved_asset = $resolver->resolve($asset, $path);
    self::assertNull($resolved_asset);
    $this->assertEmptyOutput();
  }

}
