<?php declare(strict_types=1);

namespace DrupalCodeGenerator\Tests\Unit\Asset\Resolver;

use DrupalCodeGenerator\Asset\Directory;
use DrupalCodeGenerator\Asset\File;
use DrupalCodeGenerator\Asset\Resolver\ReplaceResolver;
use DrupalCodeGenerator\Asset\Symlink;

/**
 * Tests ReplaceResolver.
 */
final class ReplaceResolverTest extends BaseResolverTest {

  /**
   * Test callback.
   */
  public function testReplaceForced(): void {
    $resolver = new ReplaceResolver($this->createGeneratorStyle());
    $this->input->setOption('replace', TRUE);

    $path = $this->createFile('log.txt');
    $asset = File::create('log.txt')->content('content');
    $resolved_asset = $resolver->resolve($asset, $path);

    self::assertNotSame($asset, $resolved_asset);

    $expected_resolved_asset = File::create('log.txt')->content('content');
    self::assertEquals($expected_resolved_asset, $resolved_asset);

    $this->assertEmptyOutput();
  }

  /**
   * Test callback.
   */
  public function testReplaceConfirmed(): void {
    $resolver = new ReplaceResolver($this->createGeneratorStyle());
    $this->setStream('Yes');

    $path = $this->createFile('log.txt');
    $asset = File::create('log.txt')->content('content');
    $resolved_asset = $resolver->resolve($asset, $path);

    self::assertNotSame($asset, $resolved_asset);

    $expected_resolved_asset = File::create('log.txt')->content('content');
    self::assertEquals($expected_resolved_asset, $resolved_asset);

    $expected_output = <<< 'TEXT'

     The file %directory%/log.txt already exists. Would you like to replace it? [Yes]:
     ➤ 
    TEXT;
    $this->assertOutput($expected_output);
  }

  /**
   * Test callback.
   */
  public function testReplaceCanceled(): void {
    $resolver = new ReplaceResolver($this->createGeneratorStyle());
    $this->setStream('No');

    $path = $this->createFile('log.txt');
    $asset = File::create('log.txt')->content('content');
    $resolved_asset = $resolver->resolve($asset, $path);

    self::assertNotSame($asset, $resolved_asset);

    $expected_resolved_asset = File::create('log.txt')->content('content')->setVirtual(TRUE);
    self::assertEquals($expected_resolved_asset, $resolved_asset);

    $expected_output = <<< 'TEXT'

     The file %directory%/log.txt already exists. Would you like to replace it? [Yes]:
     ➤ 
    TEXT;
    $this->assertOutput($expected_output);
  }

  /**
   * Test callback.
   */
  public function testSupportedAssets(): void {
    $resolver = new ReplaceResolver($this->createGeneratorStyle());
    $this->input->setOption('replace', TRUE);

    $resolver->resolve(new File('foo.txt'), 'bar.txt');
    $resolver->resolve(new Symlink('foo.link', 'foo.txt'), 'bar.link');

    self::expectExceptionObject(new \InvalidArgumentException('Wrong asset type.'));
    $resolver->resolve(new Directory('example'), 'example');
  }

}
