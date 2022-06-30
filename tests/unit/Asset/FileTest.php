<?php declare(strict_types=1);

namespace DrupalCodeGenerator\Tests\Unit\Asset;

use DrupalCodeGenerator\Asset\Asset;
use DrupalCodeGenerator\Asset\File;
use DrupalCodeGenerator\Asset\Resolver\AppendResolver;
use DrupalCodeGenerator\Asset\Resolver\PrependResolver;
use DrupalCodeGenerator\Asset\Resolver\ReplaceResolver;
use DrupalCodeGenerator\Helper\QuestionHelper;
use DrupalCodeGenerator\InputOutput\IO;
use DrupalCodeGenerator\Tests\Unit\BaseTestCase;
use Symfony\Component\Console\Helper\HelperSet;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Output\BufferedOutput;

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

    self::assertNull($file->getHeaderTemplate());
    self::assertSame('header-bar.twig', $file->headerTemplate('header-{foo}.twig')->getHeaderTemplate());

    self::assertNull($file->getTemplate());
    self::assertSame('bar.twig', $file->template('{foo}.twig')->getTemplate());
    self::assertSame('without-extension.twig', $file->template('without-extension')->getTemplate());

    self::assertNull($file->getInlineTemplate());
    self::assertSame('template', $file->inlineTemplate('template')->getInlineTemplate());

    self::assertInstanceOf(Asset::class, $file);
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

}
