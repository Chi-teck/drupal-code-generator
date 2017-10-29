<?php

namespace DrupalCodeGenerator\Tests\Generator\Drupal_8\Plugin\Field;

use DrupalCodeGenerator\Tests\Generator\GeneratorBaseTest;

/**
 * Test for d8:plugin:field:type command.
 */
class TypeTest extends GeneratorBaseTest {

  protected $class = 'Drupal_8\Plugin\Field\Type';

  protected $interaction = [
    'Module name [%default_name%]: ' => 'Example',
    'Module machine name [example]: ' => 'example',
    'Plugin label [Example]: ' => 'Foo',
    'Plugin ID [example_foo]: ' => 'foo',
  ];

  protected $fixtures = [
    'config/schema/example.schema.yml' => __DIR__ . '/_type_schema.yml',
    'src/Plugin/Field/FieldType/FooItem.php' => __DIR__ . '/_type.php',
  ];

}
