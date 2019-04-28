<?php

namespace DrupalCodeGenerator\Tests\Helper;

use DrupalCodeGenerator\Asset;
use DrupalCodeGenerator\Helper\Renderer;
use DrupalCodeGenerator\Twig\TwigEnvironment;
use PHPUnit\Framework\TestCase;

/**
 * A test for renderer helper.
 */
class RendererTest extends TestCase {

  /**
   * Test callback.
   */
  public function testRenderer() {
    $twig_loader = new \Twig_Loader_Filesystem();
    $twig = new TwigEnvironment($twig_loader);
    $renderer = new Renderer($twig);
    self::assertEquals($renderer->getName(), 'dcg_renderer');
    $renderer->addPath(__DIR__);
    $content = $renderer->render('_renderer-fixture.twig', ['value' => 'foo']);
    self::assertEquals($content, "The value is: foo\n");

    $asset = new Asset();
    $asset->template('_renderer-fixture.twig');
    $asset->vars(['value' => 'foo']);
    $asset->type('directory');
    $renderer->renderAsset($asset);
    self::assertNull($asset->getContent());

    $asset->type('file');
    $renderer->renderAsset($asset);
    self::assertEquals("The value is: foo\n", $asset->getContent());

    $asset->vars(['value' => 'bar']);
    $renderer->renderAsset($asset);
    self::assertEquals("The value is: bar\n", $asset->getContent());

    $asset->content('example');
    $asset->template(NULL);
    $renderer->renderAsset($asset);
    self::assertEquals('example', $asset->getContent());
  }

}
