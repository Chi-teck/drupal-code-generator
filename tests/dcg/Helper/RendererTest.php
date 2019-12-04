<?php

namespace DrupalCodeGenerator\Tests\Helper;

use DrupalCodeGenerator\Asset\File;
use DrupalCodeGenerator\Helper\Renderer;
use DrupalCodeGenerator\Twig\TwigEnvironment;
use PHPUnit\Framework\TestCase;
use Twig\Loader\FilesystemLoader;

/**
 * A test for renderer helper.
 */
class RendererTest extends TestCase {

  /**
   * Test callback.
   */
  public function testRenderer(): void {

    $twig_loader = new FilesystemLoader();
    $twig = new TwigEnvironment($twig_loader);
    $renderer = new Renderer($twig);
    $renderer->addPath(__DIR__);

    self::assertEquals($renderer->getName(), 'renderer');

    $content = $renderer->render('_template.twig', ['value' => 'example']);
    self::assertEquals($content, "The value is example.\n");

    $asset = (new File('foo'))
      ->template('_template.twig')
      ->vars(['value' => 'foo']);
    $renderer->renderAsset($asset);
    self::assertEquals("The value is foo.\n", $asset->getContent());
    $asset->vars(['value' => 'bar']);
    $renderer->renderAsset($asset);
    self::assertEquals("The value is bar.\n", $asset->getContent());

    $asset = (new File('foo'))
      ->template('_template.twig')
      ->vars(['name' => 'foo', 'value' => 'bar'])
      ->headerTemplate('_header_template.twig');
    $renderer->renderAsset($asset);
    $expected_content = "The name is foo.\n\nThe value is bar.\n";
    self::assertEquals($expected_content, $asset->getContent());

    $asset = (new File('foo'))
      ->content('example')
      ->template(NULL);
    $renderer->renderAsset($asset);
    self::assertEquals('example', $asset->getContent());

    $asset = (new File('foo'))
      ->inlineTemplate('{{ a }} + {{ b }} = {{ a + b }}')
      ->vars(['a' => '2', 'b' => '3']);
    $renderer->renderAsset($asset);
    self::assertEquals('2 + 3 = 5', $asset->getContent());
  }

}
