<?php declare(strict_types=1);

namespace DrupalCodeGenerator\Tests\Unit\Helper\Dumper;

use DrupalCodeGenerator\Asset\File;

/**
 * Tests resolving file assets.
 */
final class FileResolverTest extends BaseResolverTest {

  /**
   * Test callback.
   */
  public function testSkip(): void {

    $path = $this->createFile('log.txt');
    $asset = (new File('log.txt'))->content('content')->skipIfExists();

    $resolver = $this->createResolver(replace: TRUE, dry_run: FALSE);
    $resolved_asset = $resolver->resolve($asset, $path);
    self::assertNull($resolved_asset);
    $this->assertEmptyOutput();

    $resolved_asset = $resolver->resolve($asset, $path);
    self::assertNull($resolved_asset);
    $this->assertEmptyOutput();
  }

  /**
   * Test callback.
   */
  public function testReplace(): void {

    $path = $this->createFile('log.txt');
    $asset = (new File('log.txt'))->content('content');

    // -- Replace = Yes.
    $resolver = $this->createResolver(replace: TRUE, dry_run: FALSE);
    $resolved_asset = $resolver->resolve($asset, $path);
    $expected_resolved_asset = clone $asset->content('content');
    self::assertEquals($expected_resolved_asset, $resolved_asset);
    $this->assertEmptyOutput();

    // -- Replace = No.
    $resolver = $this->createResolver(replace: FALSE, dry_run: FALSE);
    $resolved_asset = $resolver->resolve($asset, $path);
    self::assertNull($resolved_asset);
    $this->assertEmptyOutput();

    // -- Replace = Confirm.
    $resolver = $this->createResolver(replace: NULL, dry_run: FALSE);
    $this->setStream("Yes\n");
    $resolved_asset = $resolver->resolve($asset, $path);
    $expected_resolved_asset = clone $asset->content('content');
    self::assertEquals($expected_resolved_asset, $resolved_asset);
    $expected_output = <<< 'TEXT'

     The file %directory%/log.txt already exists. Would you like to replace it? [Yes]:
     ➤ 
    TEXT;
    $this->assertOutput($expected_output);

    $this->setStream("No\n");
    $resolved_asset = $resolver->resolve($asset, $path);
    self::assertNull($resolved_asset);

    $expected_output = <<< 'TEXT'

     The file %directory%/log.txt already exists. Would you like to replace it? [Yes]:
     ➤ 
    TEXT;
    $this->assertOutput($expected_output);
  }

  /**
   * Test callback.
   */
  public function testPrepend(): void {

    $path = $this->createFile('log.txt', 'Existing content.');
    $asset = (new File('log.txt'))->content('New content.')->prependIfExists();

    $resolver = $this->createResolver(replace: TRUE, dry_run: FALSE);
    $resolved_asset = $resolver->resolve($asset, $path);
    $expected_resolved_asset = clone $asset->content("New content.\nExisting content.");
    self::assertEquals($expected_resolved_asset, $resolved_asset);
    $this->assertEmptyOutput();
  }

  /**
   * Test callback.
   */
  public function testAppend(): void {

    $resolver = $this->createResolver(replace: TRUE, dry_run: FALSE);

    // -- Header size: 0.
    $path = $this->createFile('log.txt', 'Existing content.');
    $asset = (new File('log.txt'))->content('New content.')->appendIfExists();

    $resolved_asset = $resolver->resolve($asset, $path);
    $expected_resolved_asset = clone $asset->content("Existing content.\nNew content.");
    self::assertEquals($expected_resolved_asset, $resolved_asset);
    $this->assertEmptyOutput();

    // -- Header size: 1.
    $path = $this->createFile('log.txt', 'Existing content.');
    $asset = (new File('log.txt'))->content("Header\nNew content.")->appendIfExists()->headerSize(1);

    $resolved_asset = $resolver->resolve($asset, $path);
    $expected_resolved_asset = clone $asset->content("Existing content.\nNew content.");
    self::assertEquals($expected_resolved_asset, $resolved_asset);
    $this->assertEmptyOutput();
  }

}
