<?php

namespace DrupalCodeGenerator\Tests\Generator\Drupal_8\Plugin\Field;

use DrupalCodeGenerator\Tests\Generator\BaseGeneratorTest;

/**
 * Test for plugin:field:type command.
 */
class TypeGeneratorTest extends BaseGeneratorTest {

  protected $class = 'Plugin\Field\Type';

  protected $interaction = [
    'Module name [%default_name%]:' => 'Example',
    'Module machine name [example]:' => 'example',
    'Plugin label [Example]:' => 'Foo',
    'Plugin ID [example_foo]:' => 'foo',
    'Plugin class [FooItem]:' => 'FooItem',
    'Make the field storage configurable? [No]:' => 'Yes',
    'Make the field instance configurable? [No]:' => 'Yes',
  ];

  protected $fixtures = [
    'config/schema/example.schema.yml' => __DIR__ . '/_type_schema.yml',
    'src/Plugin/Field/FieldType/FooItem.php' => __DIR__ . '/_type.php',
  ];

}
