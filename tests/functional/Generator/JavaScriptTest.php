<?php declare(strict_types=1);

namespace DrupalCodeGenerator\Tests\Functional\Generator;

use DrupalCodeGenerator\Command\JavaScript;
use DrupalCodeGenerator\Test\Functional\GeneratorTestBase;

/**
 * Tests javascript generator.
 */
final class JavaScriptTest extends GeneratorTestBase {

  protected string $fixtureDir = __DIR__ . '/_javascript';

  public function testGenerator(): void {

    $this->execute(JavaScript::class, ['foo_bar', 'coca-cola.js']);

    $expected_display = <<< 'TXT'

     Welcome to javascript generator!
    ––––––––––––––––––––––––––––––––––

     Module machine name:
     ➤ 

     File name [foo-bar.js]:
     ➤ 

     Would you like to create a library for this file? [Yes]:
     ➤ 


     The following directories and files have been created or updated:
    –––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––
     • foo_bar.libraries.yml
     • js/coca-cola.js

    TXT;
    $this->assertDisplay($expected_display);

    $this->assertGeneratedFile('js/coca-cola.js', '_javascript.js');
    $this->assertGeneratedFile('foo_bar.libraries.yml', '_libraries.yml');
  }

}
