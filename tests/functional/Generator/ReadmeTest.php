<?php declare(strict_types = 1);

namespace DrupalCodeGenerator\Tests\Functional\Generator;

use DrupalCodeGenerator\Command\JavaScript;
use DrupalCodeGenerator\Command\Readme;
use DrupalCodeGenerator\Test\Functional\GeneratorTestBase;

/**
 * Tests javascript generator.
 */
final class ReadmeTest extends GeneratorTestBase {

  protected string $fixtureDir = __DIR__ . '/_readme';

  /**
   * Test callback.
   */
  public function testGenerator(): void {

    $this->execute(Readme::class, ['foo', 'Foo']);

    $expected_display = <<< 'TXT'

     Welcome to readme generator!
    ––––––––––––––––––––––––––––––

     Module machine name:
     ➤ 

     Module name [Foo]:
     ➤ 

     The following directories and files have been created or updated:
    –––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––
     • foo.info.yml
     • README.md

    TXT;
    $this->assertDisplay($expected_display);

    $this->assertGeneratedFile('README.md');
  }

}
