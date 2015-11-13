<?php

namespace DrupalCodeGenerator\Tests\Drupal_8\Plugin;

use DrupalCodeGenerator\Tests\GeneratorTestCase;

/**
 * Test for d8:plugin:field-widget command.
 */
class FieldWidget extends GeneratorTestCase {

  /**
   * {@inheritdoc}
   */
  public function setUp() {
    $this->class = 'Drupal_8\Plugin\FieldWidget';
    $this->answers = [
      'Foo',
      'foo',
      'Example',
      'foo_example',
    ];
    $this->target = 'ExampleWidget.php';
    $this->fixture = __DIR__ . '/_field_widget.php';

    parent::setUp();
  }

}
