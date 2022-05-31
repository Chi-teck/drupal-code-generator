<?php declare(strict_types=1);

namespace DrupalCodeGenerator\Tests\Generator\Service;

use DrupalCodeGenerator\Command\Service\Custom;
use DrupalCodeGenerator\Test\Functional\GeneratorTestBase;

/**
 * Tests service:custom generator.
 */
final class CustomTest extends GeneratorTestBase {

  protected string $fixtureDir = __DIR__ . '/_custom';

  public function testGenerator(): void {
    $input = [
      'foo',
      'foo.example',
      'Example',
      'Yes',
      'entity_type.manager',
      'cron',
      'cache_tags.invalidator',
      '',
    ];
    $this->execute(Custom::class, $input);

    $expected_display = <<< 'TXT'

     Welcome to custom-service generator!
    ––––––––––––––––––––––––––––––––––––––

     Module machine name:
     ➤ 

     Service name [foo.example]:
     ➤ 

     Class [Example]:
     ➤ 

     Would you like to inject dependencies? [Yes]:
     ➤ 

     Type the service name or use arrows up/down. Press enter to continue:
     ➤ 

     Type the service name or use arrows up/down. Press enter to continue:
     ➤ 

     Type the service name or use arrows up/down. Press enter to continue:
     ➤ 

     Type the service name or use arrows up/down. Press enter to continue:
     ➤ 

     The following directories and files have been created or updated:
    –––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––
     • foo.services.yml
     • src/Example.php

    TXT;
    $this->assertDisplay($expected_display);

    $this->assertGeneratedFile('foo.services.yml');
    $this->assertGeneratedFile('src/Example.php');
  }

}
