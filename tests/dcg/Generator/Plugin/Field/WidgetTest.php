<?php

namespace DrupalCodeGenerator\Tests\Generator\Plugin\Field;

use DrupalCodeGenerator\Tests\Generator\BaseGeneratorTest;

/**
 * Test for plugin:field:widget command.
 */
class WidgetTest extends BaseGeneratorTest {

  protected $class = 'Plugin\Field\Widget';

  protected $interaction = [
    'Module name [%default_name%]:' => 'Foo',
    'Module machine name [foo]:' => 'foo',
    'Plugin label [Example]:' => 'Example',
    'Plugin ID [foo_example]:' => 'foo_example',
    'Plugin class [ExampleWidget]:' => 'ExampleWidget',
    'Make the widget configurable? [No]:' => 'Yes',
  ];

  protected $fixtures = [
    'config/schema/foo.schema.yml' => '/_widget_schema.yml',
    'src/Plugin/Field/FieldWidget/ExampleWidget.php' => '/_widget.php',
  ];

}
