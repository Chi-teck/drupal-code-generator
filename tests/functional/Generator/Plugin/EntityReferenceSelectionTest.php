<?php declare(strict_types = 1);

namespace DrupalCodeGenerator\Tests\Functional\Generator\Plugin;

use DrupalCodeGenerator\Command\Plugin\EntityReferenceSelection;
use DrupalCodeGenerator\Test\Functional\GeneratorTestBase;

/**
 * Tests plugin:entity-reference-selection generator.
 */
final class EntityReferenceSelectionTest extends GeneratorTestBase {

  protected string $fixtureDir = __DIR__ . '/_entity_reference_selection';

  /**
   * Test callback.
   */
  public function testWithConfig(): void {
    $input = [
      'example',
      'Example',
      'node',
      'Advanced node selection',
      'example_node_selection',
      'ExampleNodeSelection',
      'Yes',
    ];
    $this->execute(EntityReferenceSelection::class, $input);

    $expected_display = <<< 'TXT'

     Welcome to entity-reference-selection generator!
    ––––––––––––––––––––––––––––––––––––––––––––––––––

     Module machine name:
     ➤ 

     Module name [Example]:
     ➤ 

     Entity type that can be referenced by this plugin [node]:
     ➤ 

     Plugin label [Advanced node selection]:
     ➤ 

     Plugin ID [example_node_selection]:
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

    $this->assertGeneratedFile(
      'config/schema/example.schema.yml',
      '_w_config/config/schema/example.schema.yml',
    );
    $this->assertGeneratedFile(
      'src/Plugin/EntityReferenceSelection/ExampleNodeSelection.php',
      '_w_config/src/Plugin/EntityReferenceSelection/ExampleNodeSelection.php',
    );
  }

  /**
   * Test callback.
   */
  public function testWithoutConfig(): void {
    $input = [
      'example',
      'Example',
      'contact_message',
      'Contact message selection',
      'contact_message_selection',
      'ContactMessageSelection',
      'No',
    ];
    $this->execute(EntityReferenceSelection::class, $input);

    $expected_display = <<< 'TXT'

     Welcome to entity-reference-selection generator!
    ––––––––––––––––––––––––––––––––––––––––––––––––––

     Module machine name:
     ➤ 

     Module name [Example]:
     ➤ 

     Entity type that can be referenced by this plugin [node]:
     ➤ 

     Plugin label [Advanced contact_message selection]:
     ➤ 

     Plugin ID [example_contact_message_selection]:
     ➤ 

     Plugin class [ContactMessageSelection]:
     ➤ 

     Provide additional plugin configuration? [No]:
     ➤ 

     The following directories and files have been created or updated:
    –––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––
     • config/schema/example.schema.yml
     • src/Plugin/EntityReferenceSelection/ContactMessageSelection.php

    TXT;
    $this->assertDisplay($expected_display);

    $this->assertGeneratedFile(
      'config/schema/example.schema.yml',
      '_n_config/config/schema/example.schema.yml',
    );
    $this->assertGeneratedFile(
      'src/Plugin/EntityReferenceSelection/ContactMessageSelection.php',
      '_n_config/src/Plugin/EntityReferenceSelection/ContactMessageSelection.php',
    );
  }

}
