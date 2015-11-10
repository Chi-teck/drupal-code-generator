<?php

namespace DrupalCodeGenerator\Tests\Drupal_8\Plugin;

use DrupalCodeGenerator\Tests\GeneratorTestCase;

/**
 * Test for d8:plugin:field-type command.
 */
class FieldType extends GeneratorTestCase {

  /**
   * {@inheritdoc}
   */
  public function setUp() {
    $this->class = 'Drupal_8\Plugin\FieldType';
    $this->answers = [
      'Field type example',
      'field_type_example',
      'Example of field type plugin.',
      'field_type_example',
    ];
    $this->target = 'FieldTypeExampleItem.php';
    $this->fixture = __DIR__ . '/_' . $this->target;

    parent::setUp();
  }

}
