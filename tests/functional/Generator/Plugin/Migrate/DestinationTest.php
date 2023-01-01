<?php declare(strict_types = 1);

namespace DrupalCodeGenerator\Tests\Functional\Generator\Plugin\Migrate;

use DrupalCodeGenerator\Command\Plugin\Migrate\Destination;
use DrupalCodeGenerator\Test\Functional\GeneratorTestBase;

/**
 * Tests plugin:migrate:destination generator.
 */
final class DestinationTest extends GeneratorTestBase {

  protected string $fixtureDir = __DIR__ . '/_destination';

  /**
   * Test callback.
   */
  public function testWithoutDependencies(): void {
    $input = [
      'example',
      'example_foo',
      'Foo',
      'No',
    ];
    $this->execute(Destination::class, $input);

    $expected_display = <<< 'TXT'

     Welcome to migrate-destination generator!
    –––––––––––––––––––––––––––––––––––––––––––

     Module machine name:
     ➤ 

     Plugin ID:
     ➤ 

     Plugin class [Foo]:
     ➤ 

     Would you like to inject dependencies? [No]:
     ➤ 

     The following directories and files have been created or updated:
    –––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––
     • src/Plugin/migrate/destination/Foo.php

    TXT;
    $this->assertDisplay($expected_display);

    $this->fixtureDir .= '/_n_deps';
    $this->assertGeneratedFile('src/Plugin/migrate/destination/Foo.php');
  }

  /**
   * Test callback.
   */
  public function testWithDependencies(): void {
    $input = [
      'example',
      'example_bar',
      'Bar',
      'Yes',
      'entity_type.manager',
      '',
    ];
    $this->execute(Destination::class, $input);

    $expected_display = <<< 'TXT'

     Welcome to migrate-destination generator!
    –––––––––––––––––––––––––––––––––––––––––––

     Module machine name:
     ➤ 

     Plugin ID:
     ➤ 

     Plugin class [Bar]:
     ➤ 

     Would you like to inject dependencies? [No]:
     ➤ 

     Type the service name or use arrows up/down. Press enter to continue:
     ➤ 

     Type the service name or use arrows up/down. Press enter to continue:
     ➤ 

     The following directories and files have been created or updated:
    –––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––
     • src/Plugin/migrate/destination/Bar.php

    TXT;
    $this->assertDisplay($expected_display);

    $this->fixtureDir .= '/_w_deps';
    $this->assertGeneratedFile('src/Plugin/migrate/destination/Bar.php');
  }

}
