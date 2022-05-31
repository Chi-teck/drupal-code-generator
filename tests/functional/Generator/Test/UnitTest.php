<?php declare(strict_types=1);

namespace DrupalCodeGenerator\Tests\Functional\Generator\Test;

use DrupalCodeGenerator\Command\Test\Unit;
use DrupalCodeGenerator\Test\Functional\GeneratorTestBase;

/**
 * Tests test:unit generator.
 */
final class UnitTest extends GeneratorTestBase {

  protected string $fixtureDir = __DIR__ . '/_unit';

  public function testGenerator(): void {

    $this->execute(Unit::class, ['foo', 'ExampleTest']);

    $expected_display = <<< 'TXT'

     Welcome to unit-test generator!
    –––––––––––––––––––––––––––––––––

     Module machine name:
     ➤ 

     Class [ExampleTest]:
     ➤ 

     The following directories and files have been created or updated:
    –––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––
     • tests/src/Unit/ExampleTest.php

    TXT;
    $this->assertDisplay($expected_display);

    $this->assertGeneratedFile('tests/src/Unit/ExampleTest.php');
  }

}
