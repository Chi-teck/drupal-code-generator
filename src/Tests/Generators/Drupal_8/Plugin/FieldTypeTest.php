<?php

namespace DrupalCodeGenerator\Tests\Drupal_8\Plugin;

use DrupalCodeGenerator\Tests\GeneratorTestCase;

/**
 * Test for d8:plugin:field-type command.
 */
class FieldTypeTest extends GeneratorTestCase {

  protected $class = 'Drupal_8\Plugin\FieldType';

  protected $answers = [
    'Example',
    'example',
    'Foo',
    'foo',
  ];

  protected $fixtures = [
    'src/Plugin/Field/FieldType/FooItem.php' => __DIR__ . '/_field_type.php',
  ];

}
