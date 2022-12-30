<?php declare(strict_types = 1);

namespace DrupalCodeGenerator\Tests\Functional\Generator\Plugin\Migrate;

use DrupalCodeGenerator\Command\Plugin\Migrate\Process;
use DrupalCodeGenerator\Test\Functional\GeneratorTestBase;

/**
 * Tests plugin:migrate:process generator.
 */
final class ProcessTest extends GeneratorTestBase {

  protected string $fixtureDir = __DIR__ . '/_process';

  /**
   * Test callback.
   */
  public function testWithoutDependencies(): void {
    $input = [
      'example',
      'example_qux',
      'Qux',
      'No',
    ];
    $this->execute(Process::class, $input);

    $expected_display = <<< 'TXT'

     Welcome to migrate-process generator!
    –––––––––––––––––––––––––––––––––––––––

     Module machine name:
     ➤ 

     Plugin ID:
     ➤ 

     Plugin class [Qux]:
     ➤ 

     Would you like to inject dependencies? [No]:
     ➤ 

     The following directories and files have been created or updated:
    –––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––
     • src/Plugin/migrate/process/Qux.php

    TXT;
    $this->assertDisplay($expected_display);

    $this->fixtureDir .= '/_n_deps';
    $this->assertGeneratedFile('src/Plugin/migrate/process/Qux.php');
  }

  /**
   * Test callback.
   */
  public function testWithDependencies(): void {
    $input = [
      'example',
      'example_qux',
      'Qux',
      'Yes',
      'entity_type.manager',
      '',
    ];
    $this->execute(Process::class, $input);

    $expected_display = <<< 'TXT'

     Welcome to migrate-process generator!
    –––––––––––––––––––––––––––––––––––––––

     Module machine name:
     ➤ 

     Plugin ID:
     ➤ 

     Plugin class [Qux]:
     ➤ 

     Would you like to inject dependencies? [No]:
     ➤ 

     Type the service name or use arrows up/down. Press enter to continue:
     ➤ 

     Type the service name or use arrows up/down. Press enter to continue:
     ➤ 

     The following directories and files have been created or updated:
    –––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––
     • src/Plugin/migrate/process/Qux.php

    TXT;
    $this->assertDisplay($expected_display);

    $this->fixtureDir .= '/_w_deps';
    $this->assertGeneratedFile('src/Plugin/migrate/process/Qux.php');
  }

}
