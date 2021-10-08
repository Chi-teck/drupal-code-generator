<?php declare(strict_types=1);

namespace DrupalCodeGenerator\Tests\Generator\Plugin;

use DrupalCodeGenerator\Tests\Generator\BaseGeneratorTest;

/**
 * Test for plugin:entity-reference-selection command.
 */
final class EntityReferenceSelectionTest extends BaseGeneratorTest {

  protected string $class = 'Plugin\EntityReferenceSelection';

  protected array $interaction = [
    'Module name [%default_name%]:' => 'Example',
    'Module machine name [example]:' => 'example',
    'Entity type that can be referenced by this plugin [node]:' => 'node',
    'Plugin label [Advanced node selection]:' => 'Advanced node selection',
    'Plugin ID [example_advanced_node_selection]:' => 'example_advanced_node_selection',
    'Plugin class [NodeSelection]:' => 'ExampleNodeSelection',
    'Provide additional plugin configuration? [No]:' => 'Yes',
  ];

  protected array $fixtures = [
    'config/schema/example.schema.yml' => '/_entity_reference_selection_schema.yml',
    'src/Plugin/EntityReferenceSelection/ExampleNodeSelection.php' => '/_entity_reference_selection.php',
  ];

}
