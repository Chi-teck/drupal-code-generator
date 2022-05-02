<?php declare(strict_types=1);

namespace DrupalCodeGenerator\Tests\Generator;

use DrupalCodeGenerator\Command\Hook;
use DrupalCodeGenerator\Test\Functional\GeneratorTestBase;

/**
 * Tests hook generator.
 */
final class HookTest extends GeneratorTestBase {

  protected string $fixtureDir = __DIR__ . '/_hook';

  public function testGenerator(): void {
    $this->execute(new Hook(), ['example', 'theme']);

    $expected_display = <<< 'TXT'

     Welcome to hook generator!
    ––––––––––––––––––––––––––––

     Module machine name [%default_name%]:
     ➤ 

     Hook name:
     ➤ 

     The following directories and files have been created or updated:
    –––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––
     • example.module

    TXT;
    $this->assertDisplay($expected_display);

    $this->assertGeneratedFile('example.module');
  }

}
