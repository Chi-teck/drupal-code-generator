<?php

namespace DrupalCodeGenerator\Tests\Drupal_8\Plugin\Field;

use DrupalCodeGenerator\Tests\GeneratorTestCase;

/**
 * Test for d8:plugin:field:type command.
 */
class TypeTest extends GeneratorTestCase {

  protected $class = 'Drupal_8\Plugin\Field\Type';

  protected $answers = [
    'Example',
    'example',
    'Foo',
    'foo',
  ];

  protected $fixtures = [
    'src/Plugin/Field/FieldType/FooItem.php' => __DIR__ . '/_type.php',
  ];

}
