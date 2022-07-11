<?php declare(strict_types = 1);

namespace DrupalCodeGenerator\Tests\Functional\Generator\Plugin;

use DrupalCodeGenerator\Command\Plugin\Condition;
use DrupalCodeGenerator\Test\Functional\GeneratorTestBase;

/**
 * Tests plugin:condition generator.
 */
final class ConditionTest extends GeneratorTestBase {

  protected string $fixtureDir = __DIR__ . '/_condition';

  public function testGenerator(): void {
    $input = [
      'foo',
      'Example',
      'foo_example',
      'Example',
    ];
    $this->execute(Condition::class, $input);

    $expected_display = <<< 'TXT'

     Welcome to condition generator!
    –––––––––––––––––––––––––––––––––

     Module machine name:
     ➤ 

     Plugin label [Example]:
     ➤ 

     Plugin ID [foo_example]:
     ➤ 

     Plugin class [Example]:
     ➤ 

     The following directories and files have been created or updated:
    –––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––
     • config/schema/foo.schema.yml
     • src/Plugin/Condition/Example.php

    TXT;
    $this->assertDisplay($expected_display);

    $this->assertGeneratedFile('config/schema/foo.schema.yml');
    $this->assertGeneratedFile('src/Plugin/Condition/Example.php');
  }

}
