<?php

namespace DrupalCodeGenerator\Tests;

use PHPUnit\Framework\TestCase;
use DrupalCodeGenerator\Twig\TwigEnvironment;

/**
 * A test for Twig environment.
 */
class TwigEnvironmentTest extends TestCase {

  /**
   * Test callback.
   */
  public function testTwigEnvironment() {
    $twig_loader = new \Twig_Loader_Filesystem(__DIR__);
    $twig = new TwigEnvironment($twig_loader);
    $expected = file_get_contents(__DIR__ . '/_twig_environment_fixture.txt');
    $result = $twig->render('twig-environment-template.twig', []);
    static::assertEquals($expected, $result);
  }

}
