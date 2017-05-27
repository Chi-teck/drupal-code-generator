<?php

namespace DrupalCodeGenerator\Tests\Generator\Drupal_8\Plugin\Field;

use DrupalCodeGenerator\Tests\Generator\GeneratorTestCase;

/**
 * Test for d8:plugin:field:widget command.
 */
class WidgetTest extends GeneratorTestCase {

  protected $class = 'Drupal_8\Plugin\Field\Widget';

  protected $answers = [
    'Foo',
    'foo',
    'Example',
    'foo_example',
  ];

  protected $fixtures = [
    'src/Plugin/Field/FieldWidget/ExampleWidget.php' => __DIR__ . '/_widget.php',
  ];

}
