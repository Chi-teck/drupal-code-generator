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
  public function testRenderer() :void {

    $twig_loader = new \Twig_Loader_Filesystem();
    $twig = new TwigEnvironment($twig_loader);
    $renderer = new Renderer($twig);
    $renderer->addPath(__DIR__);

    self::assertEquals($renderer->getName(), 'dcg_renderer');

    $content = $renderer->render('_template.twig', ['value' => 'example']);
    self::assertEquals($content, "The value is example\n");

    $asset = (new Asset())
      ->template('_template.twig')
      ->vars(['value' => 'foo'])
      ->type('directory');
    $renderer->renderAsset($asset);
    self::assertNull($asset->getContent());

    $asset = (new Asset())
      ->template('_template.twig')
      ->vars(['value' => 'foo']);
    $renderer->renderAsset($asset);
    self::assertEquals("The value is foo\n", $asset->getContent());
    $asset->vars(['value' => 'bar']);
    $renderer->renderAsset($asset);
    self::assertEquals("The value is bar\n", $asset->getContent());

    $asset = (new Asset())
      ->template('_template.twig')
      ->vars(['name' => 'foo', 'value' => 'bar'])
      ->headerTemplate('_header_template.twig');
    $renderer->renderAsset($asset);
    $expected_content = "The name is foo\n\nThe value is bar\n";
    self::assertEquals($expected_content, $asset->getContent());

    $asset = (new Asset())
      ->content('example')
      ->template(NULL);
    $renderer->renderAsset($asset);
    self::assertEquals('example', $asset->getContent());

  }

}
