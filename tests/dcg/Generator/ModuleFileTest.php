<?php declare(strict_types=1);

namespace DrupalCodeGenerator\Tests\Generator;

use DrupalCodeGenerator\Command\ModuleFile;
use DrupalCodeGenerator\Test\GeneratorTest;

/**
 * Test for module-file command.
 */
final class ModuleFileTest extends GeneratorTest {

  protected string $fixtureDir = __DIR__;

  /**
   * Test callback.
   */
  public function testGenerator(): void {

    $this->execute(new ModuleFile(), ['Foo', 'foo']);

    $expected_display = <<< 'TXT'

     Welcome to module-file generator!
    –––––––––––––––––––––––––––––––––––

     Module name [%default_name%]:
     ➤ 

     Module machine name [foo]:
     ➤ 

     The following directories and files have been created or updated:
    –––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––
     • foo.module


    TXT;
    $this->assertDisplay($expected_display);

    $this->assertGeneratedFile('foo.module', '_module_file.module');
  }

}
