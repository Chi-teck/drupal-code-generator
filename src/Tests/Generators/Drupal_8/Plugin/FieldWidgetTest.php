<?php

namespace DrupalCodeGenerator\Tests\Drupal_8\Plugin;

use DrupalCodeGenerator\Tests\GeneratorTestCase;

/**
 * Test for d8:plugin:field-widget command.
 */
class FieldWidgetTest extends GeneratorTestCase {

  protected $class = 'Drupal_8\Plugin\FieldWidget';

  protected $answers = [
    'Foo',
    'foo',
    'Example',
    'foo_example',
  ];

  protected $fixtures = [
    'src/Plugin/Field/FieldWidget/ExampleWidget.php' => __DIR__ . '/_field_widget.php',
  ];

}
