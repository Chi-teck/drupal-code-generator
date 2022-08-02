<?php declare(strict_types = 1);

namespace DrupalCodeGenerator\Tests\Functional\Generator\Plugin\Migrate;

use DrupalCodeGenerator\Command\Plugin\Migrate\Process;
use DrupalCodeGenerator\Test\Functional\GeneratorTestBase;

/**
 * Tests plugin:migrate:process generator.
 */
final class ProcessTest extends GeneratorTestBase {

  protected string $fixtureDir = __DIR__ . '/_process';

  public function testGenerator(): void {
    $input = [
      'example',
      'example_qux',
      'Qux',
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

     The following directories and files have been created or updated:
    –––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––
     • src/Plugin/migrate/process/Qux.php

    TXT;
    $this->assertDisplay($expected_display);

    $this->assertGeneratedFile('src/Plugin/migrate/process/Qux.php');
  }

}
