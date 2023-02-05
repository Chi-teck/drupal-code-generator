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
    $input = [
      'foo',
      'Foo',
      'example',
    ];
    $this->execute(Nightwatch::class, $input);

    $expected_display = <<< 'TXT'

     Welcome to nightwatch-test generator!
    –––––––––––––––––––––––––––––––––––––––

     Module machine name:
     ➤ 

     Module name [Foo]:
     ➤ 

     Test name [example]:
     ➤ 

     The following directories and files have been created or updated:
    –––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––
     • foo.info.yml
     • tests/src/Nightwatch/exampleTest.js

    TXT;
    $this->assertDisplay($expected_display);

    $this->assertGeneratedFile('tests/src/Nightwatch/exampleTest.js');
  }

}
