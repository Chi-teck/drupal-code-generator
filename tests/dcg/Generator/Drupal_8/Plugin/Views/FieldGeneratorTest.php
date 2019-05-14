<?php

namespace DrupalCodeGenerator\Tests\Generator\Drupal_8\Plugin\Views;

use DrupalCodeGenerator\Tests\Generator\BaseGeneratorTest;

/**
 * Test for d8:plugin:views:field command.
 */
class FieldGeneratorTest extends BaseGeneratorTest {

  protected $class = 'Drupal_8\Plugin\Views\Field';

  protected $interaction = [
    'Module name [%default_name%]:' => 'Foo',
    'Module machine name [foo]:' => 'foo',
    'Plugin label [Example]:' => 'Example',
    'Plugin ID [foo_example]:' => 'foo_example',
    'Plugin class [Example]:' => 'Example',
    'Make the plugin configurable? [No]:' => 'Yes',
    'Would you like to inject dependencies? [No]:' => 'Yes',
    '<1> Type the service name or use arrows up/down. Press enter to continue:' => 'entity_type.manager',
    '<2> Type the service name or use arrows up/down. Press enter to continue:' => "\n",
  ];

  protected $fixtures = [
    'config/schema/foo.views.schema.yml' => __DIR__ . '/_field_schema.yml',
    'src/Plugin/views/field/Example.php' => __DIR__ . '/_field.php',
  ];

}
