<?php declare(strict_types=1);

namespace DrupalCodeGenerator\Tests\Functional\Generator\Plugin\Field;

use DrupalCodeGenerator\Command\Plugin\Field\Widget;
use DrupalCodeGenerator\Test\Functional\GeneratorTestBase;

/**
 * Tests plugin:field:widget generator.
 */
final class WidgetTest extends GeneratorTestBase {

  protected string $fixtureDir = __DIR__ . '/_widget';

  public function testGenerator(): void {
    $input = [
      'foo',
      'Example',
      'foo_example',
      'ExampleWidget',
      'Yes',
    ];
    $this->execute(Widget::class, $input);

    $expected_display = <<< 'TXT'

     Welcome to field-widget generator!
    ––––––––––––––––––––––––––––––––––––

     Module machine name:
     ➤ 

     Plugin label:
     ➤ 

     Plugin ID [foo_example]:
     ➤ 

     Plugin class [ExampleWidget]:
     ➤ 

     Make the widget configurable? [No]:
     ➤ 

     The following directories and files have been created or updated:
    –––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––
     • config/schema/foo.schema.yml
     • src/Plugin/Field/FieldWidget/ExampleWidget.php

    TXT;
    $this->assertDisplay($expected_display);

    $this->assertGeneratedFile('config/schema/foo.schema.yml');
    $this->assertGeneratedFile('src/Plugin/Field/FieldWidget/ExampleWidget.php');
  }

}
