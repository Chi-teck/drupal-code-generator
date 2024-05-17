<?php

declare(strict_types=1);

namespace DrupalCodeGenerator\Tests\Unit;

use DrupalCodeGenerator\Twig\TwigEnvironment;
use PHPUnit\Framework\TestCase;
use Twig\Error\SyntaxError;
use Twig\Loader\FilesystemLoader;

/**
 * A test for Twig environment.
 */
final class TwigEnvironmentTest extends TestCase {

  /**
   * Test callback.
   */
  public function testTwigEnvironment(): void {
    $twig_loader = new FilesystemLoader(__DIR__);
    $twig = new TwigEnvironment($twig_loader);
    $expected = \file_get_contents(__DIR__ . '/_twig_environment_fixture.txt');
    \error_reporting(\error_reporting() & ~ \E_USER_WARNING);
    $result = $twig->render('twig-environment-template.twig');
    self::assertSame($expected, $result);
  }

  /**
   * Test callback.
   */
  public function testDeprecateTagTwigEnvironment(): void {
    $twig_loader = new FilesystemLoader(__DIR__);
    $twig = new TwigEnvironment($twig_loader);
    $this->expectException(SyntaxError::class);
    $this->expectExceptionMessage('An exception has been thrown during the compilation of a template ("The sort tag is deprecated in 3.6.0 and will be removed in 4.x, use the sort_namespaces twig filter.") in "twig-environment-template.twig".');
    $twig->render('twig-environment-template.twig');
  }

}
