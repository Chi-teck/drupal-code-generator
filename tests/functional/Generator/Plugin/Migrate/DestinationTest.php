<?php declare(strict_types = 1);

namespace DrupalCodeGenerator\Tests\Functional\Generator\Plugin\Migrate;

use DrupalCodeGenerator\Command\Plugin\Migrate\Destination;
use DrupalCodeGenerator\Test\Functional\GeneratorTestBase;

/**
 * Tests plugin:migrate:destination generator.
 */
final class DestinationTest extends GeneratorTestBase {

  protected string $fixtureDir = __DIR__ . '/_destination';

  public function testGenerator(): void {
    $input = [
      'example',
      'example_bar',
      'Bar',
    ];
    $this->execute(Destination::class, $input);

    $expected_display = <<< 'TXT'

     Welcome to migrate-destination generator!
    –––––––––––––––––––––––––––––––––––––––––––

     Module machine name:
     ➤ 

     Plugin ID [example_example]:
     ➤ 

     Plugin class [Bar]:
     ➤ 

     The following directories and files have been created or updated:
    –––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––
     • src/Plugin/migrate/destination/Bar.php

    TXT;
    $this->assertDisplay($expected_display);

    $this->assertGeneratedFile('src/Plugin/migrate/destination/Bar.php');
  }

}
