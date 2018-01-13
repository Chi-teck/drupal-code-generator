<?php

namespace DrupalCodeGenerator\Tests;

use DrupalCodeGenerator\Asset;
use PHPUnit\Framework\TestCase;
use DrupalCodeGenerator\Helper\Renderer;

/**
 * A test for asset.
 */
class AssetTest extends TestCase {

  /**
   * Test callback.
   */
  public function testGetPath() {
    $asset = new Asset();

    $asset->path('aaa/{foo}/bbb');
    self::assertEquals('aaa/{foo}/bbb', $asset->getPath());

    $asset->vars(['foo' => 'bar']);
    self::assertEquals('aaa/bar/bbb', $asset->getPath());
  }

  /**
   * Test callback.
   */
  public function testGetMode() {
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
  public function testIsDirectory() {
    $asset = new Asset();

    self::assertFalse($asset->isDirectory());

    $asset->type('directory');
    self::assertTrue($asset->isDirectory());
  }

  /**
   * Test callback.
   */
  public function testRender() {

    $renderer = $this->createMock(Renderer::class);
    $render = function ($template, $vars) {
      return $template . ' <- ' . json_encode($vars);
    };
    $renderer->method('render')
      ->will($this->returnCallback($render));

    // Default condition.
    $asset = new Asset();
    $asset->template('foo.twig');
    $asset->render($renderer);
    self::assertEquals('foo.twig <- []', $asset->getContent());

    // The should not render anything because the content is already set.
    $asset->template('bar.twig');
    $asset->vars(['example' => 123]);
    $asset->render($renderer);
    self::assertEquals('foo.twig <- []', $asset->getContent());

    // Reset content to see above changes.
    $asset->content(NULL);
    $asset->render($renderer);
    self::assertEquals('bar.twig <- {"example":123}', $asset->getContent());

    // Add header template.
    $asset->content(NULL);
    $asset->headerTemplate('header.twig');
    $asset->render($renderer);
    self::assertEquals('header.twig <- {"example":123}' . "\n" . 'bar.twig <- {"example":123}', $asset->getContent());
  }

}
