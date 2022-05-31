<?php declare(strict_types=1);

namespace DrupalCodeGenerator\Tests\Functional\Generator\Plugin;

use DrupalCodeGenerator\Command\Plugin\EntityReferenceSelection;
use DrupalCodeGenerator\Test\Functional\GeneratorTestBase;

/**
 * Tests plugin:entity-reference-selection generator.
 */
final class EntityReferenceSelectionTest extends GeneratorTestBase {

  protected string $fixtureDir = __DIR__ . '/_entity_reference_selection';

  public function testGenerator(): void {
    $input = [
      'Example',
      'example',
      'node',
      'Advanced node selection',
      'example_advanced_node_selection',
      'ExampleNodeSelection',
      'Yes',
    ];
    $this->execute(EntityReferenceSelection::class, $input);

    $expected_display = <<< 'TXT'

     Welcome to entity-reference-selection generator!
    ––––––––––––––––––––––––––––––––––––––––––––––––––

     Module name:
     ➤ 

     Module machine name [example]:
     ➤ 

     Entity type that can be referenced by this plugin [node]:
     ➤ 

     Plugin label [Advanced node selection]:
     ➤ 

     Plugin ID [example_advanced_node_selection]:
     ➤ 

     Plugin class [NodeSelection]:
     ➤ 

     Provide additional plugin configuration? [No]:
     ➤ 

     The following directories and files have been created or updated:
    –––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––
     • config/schema/example.schema.yml
     • src/Plugin/EntityReferenceSelection/ExampleNodeSelection.php

    TXT;
    $this->assertDisplay($expected_display);

    $this->assertGeneratedFile('config/schema/example.schema.yml');
    $this->assertGeneratedFile('src/Plugin/EntityReferenceSelection/ExampleNodeSelection.php');
  }

}
