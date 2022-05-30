<?php declare(strict_types=1);

namespace DrupalCodeGenerator\Tests\Functional\Generator\Service;

use DrupalCodeGenerator\Command\Service\TwigExtension;
use DrupalCodeGenerator\Test\Functional\GeneratorTestBase;

/**
 * Tests service:twig-extension generator.
 */
final class TwigExtensionTest extends GeneratorTestBase {

  protected string $fixtureDir = __DIR__ . '/_twig_extension';

  public function testGenerator(): void {
    $input = [
      'example',
      'ExampleTwigExtension',
      'Yes',
      'entity_type.manager',
      '',
    ];
    $this->execute(TwigExtension::class, $input);

    $expected_display = <<< 'TXT'

     Welcome to twig-extension generator!
    ––––––––––––––––––––––––––––––––––––––

     Module machine name [%default_name%]:
     ➤ 

     Class [ExampleTwigExtension]:
     ➤ 

     Would you like to inject dependencies? [Yes]:
     ➤ 

     Type the service name or use arrows up/down. Press enter to continue:
     ➤ 

     Type the service name or use arrows up/down. Press enter to continue:
     ➤ 

     The following directories and files have been created or updated:
    –––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––
     • example.services.yml
     • src/ExampleTwigExtension.php

    TXT;
    $this->assertDisplay($expected_display);

    $this->assertGeneratedFile('example.services.yml');
    $this->assertGeneratedFile('src/ExampleTwigExtension.php');
  }

}
