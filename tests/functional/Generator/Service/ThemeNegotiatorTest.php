<?php declare(strict_types = 1);

namespace DrupalCodeGenerator\Tests\Functional\Generator\Service;

use DrupalCodeGenerator\Command\Service\ThemeNegotiator;
use DrupalCodeGenerator\Test\Functional\GeneratorTestBase;

/**
 * Tests service:theme-negotiator generator.
 */
final class ThemeNegotiatorTest extends GeneratorTestBase {

  protected string $fixtureDir = __DIR__ . '/_theme_negotiator';

  public function testGenerator(): void {

    $this->execute(ThemeNegotiator::class, ['foo', 'FooNegotiator']);

    $expected_display = <<< 'TXT'

     Welcome to theme-negotiator generator!
    ––––––––––––––––––––––––––––––––––––––––

     Module machine name:
     ➤ 

     Class [FooNegotiator]:
     ➤ 

     The following directories and files have been created or updated:
    –––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––
     • foo.services.yml
     • src/Theme/FooNegotiator.php

    TXT;
    $this->assertDisplay($expected_display);

    $this->assertGeneratedFile('foo.services.yml');
    $this->assertGeneratedFile('src/Theme/FooNegotiator.php');
  }

}
