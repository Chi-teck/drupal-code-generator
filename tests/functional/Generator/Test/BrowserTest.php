<?php declare(strict_types = 1);

namespace DrupalCodeGenerator\Tests\Functional\Generator\Test;

use DrupalCodeGenerator\Command\Test\Browser;
use DrupalCodeGenerator\Test\Functional\GeneratorTestBase;

/**
 * Tests test:browser generator.
 */
final class BrowserTest extends GeneratorTestBase {

  protected string $fixtureDir = __DIR__ . '/_browser';

  public function testGenerator(): void {

    $this->execute(Browser::class, ['foo', 'ExampleTest']);

    $expected_display = <<< 'TXT'

     Welcome to browser-test generator!
    ––––––––––––––––––––––––––––––––––––

     Module machine name:
     ➤ 

     Class [ExampleTest]:
     ➤ 

     The following directories and files have been created or updated:
    –––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––
     • tests/src/Functional/ExampleTest.php

    TXT;
    $this->assertDisplay($expected_display);

    $this->assertGeneratedFile('tests/src/Functional/ExampleTest.php');
  }

}
