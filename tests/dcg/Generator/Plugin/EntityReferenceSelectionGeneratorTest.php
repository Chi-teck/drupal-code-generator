<?php

namespace DrupalCodeGenerator\Tests\Generator\Plugin;

use DrupalCodeGenerator\Tests\Generator\BaseGeneratorTest;

/**
 * Test for plugin:entity-reference-selection command.
 */
class EntityReferenceSelectionGeneratorTest extends BaseGeneratorTest {

  protected $class = 'Plugin\EntityReferenceSelection';

  protected $interaction = [
    'Module name [%default_name%]:' => 'Example',
    'Module machine name [example]:' => 'example',
    'Entity type that can be referenced by this plugin [node]:' => 'node',
    'Plugin label [Advanced node selection]:' => 'Advanced node selection',
    'Plugin ID [example_advanced_node_selection]:' => 'example_advanced_node_selection',
    'Plugin class [NodeSelection]:' => 'ExampleNodeSelection',
    'Provide additional plugin configuration? [No]:' => 'Yes',
  ];

  protected $fixtures = [
    'config/schema/example.schema.yml' => __DIR__ . '/_entity_reference_selection_schema.yml',
    'src/Plugin/EntityReferenceSelection/ExampleNodeSelection.php' => __DIR__ . '/_entity_reference_selection.php',
  ];

}
