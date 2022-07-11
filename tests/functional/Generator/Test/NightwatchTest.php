<?php declare(strict_types = 1);

namespace DrupalCodeGenerator\Tests\Functional\Generator\Test;

use DrupalCodeGenerator\Command\Test\Nightwatch;
use DrupalCodeGenerator\Test\Functional\GeneratorTestBase;

/**
 * Tests test:nightwatch generator.
 */
final class NightwatchTest extends GeneratorTestBase {

  protected string $fixtureDir = __DIR__ . '/_nightwatch';

  public function testGenerator(): void {

    $this->execute(Nightwatch::class, ['foo', 'example']);

    $expected_display = <<< 'TXT'

     Welcome to nightwatch-test generator!
    –––––––––––––––––––––––––––––––––––––––

     Module machine name:
     ➤ 

     Test name [example]:
     ➤ 

     The following directories and files have been created or updated:
    –––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––
     • tests/src/Nightwatch/exampleTest.js

    TXT;
    $this->assertDisplay($expected_display);

    $this->assertGeneratedFile('tests/src/Nightwatch/exampleTest.js');
  }

}
