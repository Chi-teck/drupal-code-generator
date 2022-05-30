<?php declare(strict_types=1);

namespace DrupalCodeGenerator\Tests\Functional\Generator\Yaml;

use DrupalCodeGenerator\Command\Yml\Breakpoints;
use DrupalCodeGenerator\Test\Functional\GeneratorTestBase;

/**
 * Tests yml:breakpoints generator.
 */
final class BreakpointsTest extends GeneratorTestBase {

  protected string $fixtureDir = __DIR__ . '/_breakpoints';

  public function testGenerator(): void {

    $this->execute(Breakpoints::class, ['example']);

    $expected_display = <<< 'TXT'

     Welcome to breakpoints generator!
    –––––––––––––––––––––––––––––––––––

     Theme machine name [%default_name%]:
     ➤ 

     The following directories and files have been created or updated:
    –––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––
     • example.breakpoints.yml

    TXT;
    $this->assertDisplay($expected_display);

    $this->assertGeneratedFile('example.breakpoints.yml');
  }

}
