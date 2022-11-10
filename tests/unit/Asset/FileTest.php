<?php declare(strict_types = 1);

namespace DrupalCodeGenerator\Tests\Unit\Asset;

use DrupalCodeGenerator\Asset\Asset;
use DrupalCodeGenerator\Asset\File;
use DrupalCodeGenerator\Asset\Resolver\AppendResolver;
use DrupalCodeGenerator\Asset\Resolver\PrependResolver;
use DrupalCodeGenerator\Asset\Resolver\ReplaceResolver;
use DrupalCodeGenerator\Helper\QuestionHelper;
use DrupalCodeGenerator\Helper\Renderer\TwigRenderer;
use DrupalCodeGenerator\InputOutput\IO;
use DrupalCodeGenerator\Logger\ConsoleLogger;
use DrupalCodeGenerator\Tests\Unit\BaseTestCase;
use DrupalCodeGenerator\Twig\TwigEnvironment;
use Symfony\Component\Console\Helper\HelperSet;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Output\BufferedOutput;
use Symfony\Component\Console\Output\NullOutput;
use Twig\Loader\FilesystemLoader;

/**
 * Tests file asset.
 */
final class FileTest extends BaseTestCase {

  /**
   * Test callback.
   */
  public function testGettersAndSetters(): void {
    $file = File::create('example.txt')->vars(['foo' => 'bar']);

    self::assertSame('example.txt', $file->getPath());
    self::assertSame(0644, $file->getMode());

    self::assertSame('', $file->getContent());

    self::assertInstanceOf(Asset::class, $file);
  }

  /**
   * Test callback.
   */
  public function testRegularTemplateAfterInlineTemplate(): void {
    $this->expectExceptionObject(new \LogicException('A file cannot have both inline and regular templates.'));
    File::create('example.txt')
      ->inlineTemplate('template')
      ->template('_template.twig');
  }

  /**
   * Test callback.
   */
  public function testInlineTemplateAfterRegulaTemplate(): void {
    $this->expectExceptionObject(new \LogicException('A file cannot have both inline and regular templates.'));
    File::create('example.txt')
      ->template('_template.twig')
      ->inlineTemplate('template');
  }

  /**
   * Test callback.
   */
  public function testIsPhp(): void {
    self::assertFalse(File::create('example')->isPhp());
    self::assertFalse(File::create('example.txt')->isPhp());
    self::assertFalse(File::create('example.json')->isPhp());
    self::assertTrue(File::create('example.php')->isPhp());
    self::assertTrue(File::create('example.module')->isPhp());
    self::assertTrue(File::create('example.install')->isPhp());
    self::assertTrue(File::create('example.inc')->isPhp());
    self::assertTrue(File::create('example.theme')->isPhp());
  }

  /**
   * Test callback.
   */
  public function testResolvers(): void {
    $file = File::create('example.txt');

    $io = self::createIO();
    self::assertInstanceOf(ReplaceResolver::class, $file->getResolver($io));

    $file->prependIfExists();
    self::assertInstanceOf(PrependResolver::class, $file->getResolver($io));

    $file->appendIfExists();
    self::assertInstanceOf(AppendResolver::class, $file->getResolver($io));
  }

  /**
   * Test callback.
   */
  public function testRender(): void {
    $file = File::create('example.txt')
      ->content('must be overridden')
      ->inlineTemplate('- {{ foo * 5 }} -')
      ->vars(['foo' => 10]);
    $file->render(self::createRenderer());
    self::assertSame('- 50 -', $file->getContent());

    $file = File::create('example.txt')
      ->content('must be overridden')
      ->template('_template.twig')
      ->vars(['foo' => 'bar']);
    $file->render(self::createRenderer());
    self::assertSame("-= bar =-\n", $file->getContent());

    $file = File::create('example.txt')
      ->content('must not be overridden');
    $file->render(self::createRenderer());
    self::assertSame('must not be overridden', $file->getContent());
  }

  /**
   * Creates IO object.
   *
   * @phpcs:disable Drupal.NamingConventions.ValidFunctionName.ScopeNotCamelCaps
   */
  private static function createIO(): IO {
    $input = new ArrayInput([]);
    $output = new BufferedOutput();
    $question_helper = new QuestionHelper();
    $helper_set = new HelperSet();
    $helper_set->set($question_helper);
    return new IO($input, $output, $question_helper);
  }

  /**
   * Creates renderer.
   */
  private static function createRenderer(): TwigRenderer {
    $twig_loader = new FilesystemLoader();
    $twig = new TwigEnvironment($twig_loader);
    $renderer = new TwigRenderer($twig);
    $renderer->registerTemplatePath(__DIR__);
    $logger = new ConsoleLogger(new NullOutput());
    $renderer->setLogger($logger);
    return $renderer;
  }

}
