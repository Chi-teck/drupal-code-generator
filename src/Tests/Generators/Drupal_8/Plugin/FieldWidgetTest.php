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
      'Field widget example',
      'field_widget_example',
      'Example of field widget plugin.',
      'field_widget_example',
    ];
    $this->target = 'FieldWidgetExampleWidget.php';
    $this->fixture = __DIR__ . '/_' . $this->target;

    parent::setUp();
  }

}
