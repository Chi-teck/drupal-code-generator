<?php declare(strict_types=1);

namespace DrupalCodeGenerator\Tests\Generator\Plugin\Field;

use DrupalCodeGenerator\Tests\Generator\BaseGeneratorTest;

/**
 * Test for plugin:field:widget command.
 */
final class WidgetTest extends BaseGeneratorTest {

  protected string $class = 'Plugin\Field\Widget';

  protected array $interaction = [
    'Module name [%default_name%]:' => 'Foo',
    'Module machine name [foo]:' => 'foo',
    'Plugin label [Example]:' => 'Example',
    'Plugin ID [foo_example]:' => 'foo_example',
    'Plugin class [ExampleWidget]:' => 'ExampleWidget',
    'Make the widget configurable? [No]:' => 'Yes',
  ];

  protected array $fixtures = [
    'config/schema/foo.schema.yml' => '/_widget_schema.yml',
    'src/Plugin/Field/FieldWidget/ExampleWidget.php' => '/_widget.php',
  ];

}
