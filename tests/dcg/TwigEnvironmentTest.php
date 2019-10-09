<?php

namespace DrupalCodeGenerator\Tests;

use DrupalCodeGenerator\Twig\TwigEnvironment;
use PHPUnit\Framework\TestCase;
use Twig\Loader\FilesystemLoader;

/**
 * A test for Twig environment.
 */
class TwigEnvironmentTest extends TestCase {

  /**
   * Test callback.
   */
  public function testTwigEnvironment(): void {
    $twig_loader = new FilesystemLoader(__DIR__);
    $twig = new TwigEnvironment($twig_loader);
    $expected = file_get_contents(__DIR__ . '/_twig_environment_fixture.txt');
    $result = $twig->render('twig-environment-template.twig', []);
    static::assertEquals($expected, $result);
  }

}
