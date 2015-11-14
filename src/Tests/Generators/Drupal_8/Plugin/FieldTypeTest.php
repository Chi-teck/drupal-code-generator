<?php

namespace DrupalCodeGenerator\Tests\Drupal_8\Plugin;

use DrupalCodeGenerator\Tests\GeneratorTestCase;

/**
 * Test for d8:plugin:field-type command.
 */
class FieldTypeTest extends GeneratorTestCase {

  /**
   * {@inheritdoc}
   */
  public function setUp() {
    $this->class = 'Drupal_8\Plugin\FieldType';
    $this->answers = [
      'Example',
      'example',
      'Foo',
      'foo',
    ];
    $this->target = 'FooItem.php';
    $this->fixture = __DIR__ . '/_field_type.php';

    parent::setUp();
  }

}
