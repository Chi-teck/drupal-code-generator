<?php

declare(strict_types=1);

namespace DrupalCodeGenerator\Tests\Unit\Asset;

use DrupalCodeGenerator\Asset\File;
use DrupalCodeGenerator\Asset\Resolver\PreserveResolver;
use DrupalCodeGenerator\Asset\Resolver\ReplaceResolver;
use DrupalCodeGenerator\Helper\QuestionHelper;
use DrupalCodeGenerator\InputOutput\IO;
use DrupalCodeGenerator\Tests\Unit\BaseTestCase;
use Symfony\Component\Console\Helper\HelperSet;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Output\BufferedOutput;

/**
 * Tests asset base class.
 */
final class AssetTest extends BaseTestCase {

  /**
   * Test callback.
   */
  public function testGettersAndSetters(): void {
    $asset = File::create('foo.txt');

    self::assertSame('foo.txt', $asset->getPath());
    self::assertSame('foo.txt', (string) $asset);

    self::assertSame(0644, $asset->getMode());
    self::assertSame(0777, $asset->mode(0777)->getMode());

    self::assertFalse($asset->isVirtual());
    self::assertTrue($asset->setVirtual(TRUE)->isVirtual());
    self::assertFalse($asset->setVirtual(FALSE)->isVirtual());

    self::assertSame([], $asset->getVars());
    self::assertSame(['a' => 'b'], $asset->vars(['a' => 'b'])->getVars());
  }

  /**
   * Test callback.
   */
  public function testResolvers(): void {
    $asset = File::create('foo.txt');

    $io = self::createIO();
    self::assertInstanceOf(ReplaceResolver::class, $asset->getResolver($io));

    $asset->preserveIfExists();
    self::assertInstanceOf(PreserveResolver::class, $asset->getResolver($io));

    $asset->replaceIfExists();
    self::assertInstanceOf(ReplaceResolver::class, $asset->getResolver($io));
  }

  /**
   * Test callback.
   */
  public function testReplaceTokens(): void {
    $asset = File::create('src/{class}.php');
    self::assertSame('src/{class}.php', $asset->getPath());
    $asset->vars(['class' => 'Example']);
    self::assertSame('src/Example.php', $asset->getPath());
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
