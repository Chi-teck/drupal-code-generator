<?php declare(strict_types=1);

namespace DrupalCodeGenerator\Tests\Functional\Generator\Plugin;

use DrupalCodeGenerator\Command\Plugin\Filter;
use DrupalCodeGenerator\Test\Functional\GeneratorTestBase;

/**
 * Tests plugin:filter generator.
 */
final class FilterTest extends GeneratorTestBase {

  protected string $fixtureDir = __DIR__ . '/_filter';

  public function testGenerator(): void {
    $input = [
      'foo',
      'Foo',
      'Example',
      'foo_example',
      'Example',
      '1',
    ];
    $this->execute(Filter::class, $input);

    $expected_display = <<< 'TXT'

     Welcome to filter generator!
    ––––––––––––––––––––––––––––––

     Module machine name:
     ➤ 

     Module name [Foo]:
     ➤ 

     Plugin label:
     ➤ 

     Plugin ID [foo_example]:
     ➤ 

     Plugin class [Example]:
     ➤ 

     Filter type:
      [1] HTML restrictor
      [2] Markup language
      [3] Irreversible transformation
      [4] Reversible transformation
     ➤ 

     The following directories and files have been created or updated:
    –––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––
     • config/schema/foo.schema.yml
     • src/Plugin/Filter/Example.php

    TXT;
    $this->assertDisplay($expected_display);

    $this->assertGeneratedFile('config/schema/foo.schema.yml');
    $this->assertGeneratedFile('src/Plugin/Filter/Example.php');
  }

}
