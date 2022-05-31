<?php declare(strict_types=1);

namespace DrupalCodeGenerator\Tests\Functional\Generator\Yaml;

use DrupalCodeGenerator\Command\Yml\ModuleInfo;
use DrupalCodeGenerator\Test\Functional\GeneratorTestBase;

/**
 * Tests yml:module-info generator.
 */
final class ModuleInfoTest extends GeneratorTestBase {

  protected string $fixtureDir = __DIR__ . '/_module_info';

  public function testGenerator(): void {
    $input = [
      'example',
      'Example description.',
      'Custom',
      'example.settings',
      'views, node, fields',
    ];
    $this->execute(ModuleInfo::class, $input);

    $expected_display = <<< 'TXT'

     Welcome to module-info generator!
    –––––––––––––––––––––––––––––––––––

     Module machine name:
     ➤ 

     Description [Module description.]:
     ➤ 

     Package [Custom]:
     ➤ 

     Configuration page (route name):
     ➤ 

     Dependencies (comma separated):
     ➤ 

     The following directories and files have been created or updated:
    –––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––
     • example.info.yml

    TXT;
    $this->assertDisplay($expected_display);

    $this->assertGeneratedFile('example.info.yml');
  }

}
