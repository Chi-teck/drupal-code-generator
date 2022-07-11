<?php declare(strict_types = 1);

namespace DrupalCodeGenerator\Tests\Unit\Helper;

use DrupalCodeGenerator\Asset\File;
use DrupalCodeGenerator\Helper\Renderer;
use DrupalCodeGenerator\Logger\ConsoleLogger;
use DrupalCodeGenerator\Twig\TwigEnvironment;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Console\Output\BufferedOutput;
use Symfony\Component\Console\Output\OutputInterface;
use Twig\Loader\FilesystemLoader;

/**
 * A test for renderer helper.
 */
final class RendererTest extends TestCase {

  /**
   * The renderer to test.
   */
  private readonly Renderer $renderer;

  /**
   * Logger output.
   */
  private readonly BufferedOutput $output;

  /**
   * {@inheritdoc}
   */
  protected function setUp(): void {
    parent::setUp();
    $this->renderer = new Renderer(new TwigEnvironment(new FilesystemLoader()));
    $this->renderer->registerTemplatePath(__DIR__);
    $this->output = new BufferedOutput(OutputInterface::VERBOSITY_DEBUG);
    $logger = new ConsoleLogger($this->output);
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

  /**
   * Test callback.
   */
  public function testLogger(): void {
    File::create('foo')
      ->template('_template.twig')
      ->vars(['value' => 'example'])
      ->render($this->renderer);
    self::assertSame("[debug] Rendered template: _template.twig\n", $this->output->fetch());
  }

}
