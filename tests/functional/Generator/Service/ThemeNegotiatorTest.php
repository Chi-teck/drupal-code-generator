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

    $input = [
      'foo',
      'FooNegotiator',
      'Yes',
      'entity_type.manager',
      '',
    ];
    $this->execute(ThemeNegotiator::class, $input);

    $expected_display = <<< 'TXT'

     Welcome to theme-negotiator generator!
    ––––––––––––––––––––––––––––––––––––––––

     Module machine name:
     ➤ 

     Class [FooNegotiator]:
     ➤ 

     Would you like to inject dependencies? [Yes]:
     ➤ 

     Type the service name or use arrows up/down. Press enter to continue:
     ➤ 

     Type the service name or use arrows up/down. Press enter to continue:
     ➤ 

     The following directories and files have been created or updated:
    –––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––
     • foo.info.yml
     • foo.services.yml
     • src/Theme/FooNegotiator.php

    TXT;
    $this->assertDisplay($expected_display);

    $this->assertGeneratedFile('foo.services.yml');
    $this->assertGeneratedFile('src/Theme/FooNegotiator.php');
  }

}
