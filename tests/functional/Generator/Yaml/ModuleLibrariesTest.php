<?php declare(strict_types=1);

namespace DrupalCodeGenerator\Tests\Functional\Generator\Yaml;

use DrupalCodeGenerator\Command\Yml\ModuleLibraries;
use DrupalCodeGenerator\Test\Functional\GeneratorTestBase;

/**
 * Tests yml:module-libraries generator.
 */
final class ModuleLibrariesTest extends GeneratorTestBase {

  protected string $fixtureDir = __DIR__ . '/_module_libraries';

  public function testGenerator(): void {

    $this->execute(ModuleLibraries::class, ['example']);

    $expected_display = <<< 'TXT'

     Welcome to module-libraries generator!
    ––––––––––––––––––––––––––––––––––––––––

     Module machine name [%default_name%]:
     ➤ 

     The following directories and files have been created or updated:
    –––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––
     • example.libraries.yml

    TXT;
    $this->assertDisplay($expected_display);

    $this->assertGeneratedFile('example.libraries.yml');
  }

}
