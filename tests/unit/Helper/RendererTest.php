<?php declare(strict_types=1);

namespace DrupalCodeGenerator\Tests\Unit\Helper;

use DrupalCodeGenerator\Asset\File;
use DrupalCodeGenerator\Helper\Renderer;
use DrupalCodeGenerator\Logger\ConsoleLogger;
use DrupalCodeGenerator\Twig\TwigEnvironment;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Console\Output\NullOutput;
use Twig\Loader\FilesystemLoader;

/**
 * A test for renderer helper.
 */
final class RendererTest extends TestCase {

  /**
   * The renderer to test.
   */
  private Renderer $renderer;

  /**
   * {@inheritdoc}
   */
  public function setUp(): void {
    parent::setUp();
    $twig_loader = new FilesystemLoader();
    $twig = new TwigEnvironment($twig_loader);
    $this->renderer = new Renderer($twig);
    $this->renderer->registerTemplatePath(__DIR__);
    $logger = new ConsoleLogger(new NullOutput());
    $this->renderer->setLogger($logger);
  }

  /**
   * Test callback.
   */
  public function testRender(): void {
    $content = $this->renderer->render('_template.twig', ['value' => 'example']);
    self::assertSame($content, "The value is example.\n");
  }

  /**
   * Test callback.
   */
  public function testRenderAsset(): void {
    $asset = File::create('foo')
      ->template('_template.twig')
      ->vars(['value' => 'foo']);
    $this->renderer->renderAsset($asset);
    self::assertSame("The value is foo.\n", $asset->getContent());

    $asset->vars(['value' => 'bar']);
    $this->renderer->renderAsset($asset);
    self::assertSame("The value is bar.\n", $asset->getContent());
  }

  /**
   * Test callback.
   */
  public function testRenderAssetWithContent(): void {
    $asset = File::create('foo')->content('example');
    $this->renderer->renderAsset($asset);
    self::assertSame('example', $asset->getContent());
  }

  /**
   * Test callback.
   */
  public function testRenderAssetWithInlineTemplate(): void {
    $asset = File::create('foo')
      ->inlineTemplate('{{ a }} + {{ b }} = {{ a + b }}')
      ->vars(['a' => '2', 'b' => '3']);
    $this->renderer->renderAsset($asset);
    self::assertSame('2 + 3 = 5', $asset->getContent());
  }

}
