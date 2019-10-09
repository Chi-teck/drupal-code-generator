<?php

namespace DrupalCodeGenerator\Tests;

use DrupalCodeGenerator\Asset;
use PHPUnit\Framework\TestCase;

/**
 * A test for asset.
 */
class AssetTest extends TestCase {

  /**
   * Test callback.
   */
  public function testGetPath(): void {
    $asset = new Asset();

    $asset->path('aaa/{foo}/bbb');
    self::assertEquals('aaa/{foo}/bbb', $asset->getPath());

    $asset->vars(['foo' => 'bar']);
    self::assertEquals('aaa/bar/bbb', $asset->getPath());
  }

  /**
   * Test callback.
   */
  public function testGetMode(): void {
    $asset = new Asset();

    self::assertEquals(0644, $asset->getMode());

    $asset->type('directory');
    self::assertEquals(0755, $asset->getMode());

    $asset->mode(0444);
    self::assertEquals(0444, $asset->getMode());
  }

  /**
   * Test callback.
   */
  public function testIsDirectory(): void {
    $asset = new Asset();

    self::assertFalse($asset->isDirectory());

    $asset->type('directory');
    self::assertTrue($asset->isDirectory());
  }

  /**
   * Test callback.
   */
  public function testTemplate(): void {
    $asset = new Asset();

    $asset->template('foo');
    self::assertEquals('foo.twig', $asset->getTemplate());

    $asset->template('bar.twig');
    self::assertEquals('bar.twig', $asset->getTemplate());
  }

  /**
   * Test callback.
   */
  public function testHeaderTemplate(): void {
    $asset = new Asset();

    $asset->headerTemplate('foo');
    self::assertEquals('foo.twig', $asset->getHeaderTemplate());

    $asset->headerTemplate('bar.twig');
    self::assertEquals('bar.twig', $asset->getHeaderTemplate());
  }

}
