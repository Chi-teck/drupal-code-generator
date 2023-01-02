<?php declare(strict_types = 1);

namespace DrupalCodeGenerator\Tests\Functional\Generator\Plugin\Field;

use DrupalCodeGenerator\Command\Plugin\Field\Widget;
use DrupalCodeGenerator\Test\Functional\GeneratorTestBase;

/**
 * Tests plugin:field:widget generator.
 */
final class WidgetTest extends GeneratorTestBase {

  protected string $fixtureDir = __DIR__ . '/_widget';

  /**
   * Test callback.
   */
  public function testWithoutDependencies(): void {
    $input = [
      'foo',
      'Example',
      'foo_example',
      'ExampleWidget',
      'Yes',
      'No',
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

     Would you like to inject dependencies? [No]:
     ➤ 

     The following directories and files have been created or updated:
    –––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––
     • config/schema/foo.schema.yml
     • src/Plugin/Field/FieldWidget/ExampleWidget.php

    TXT;
    $this->assertDisplay($expected_display);

    $this->fixtureDir .= '/_n_deps';
    $this->assertGeneratedFile('config/schema/foo.schema.yml');
    $this->assertGeneratedFile('src/Plugin/Field/FieldWidget/ExampleWidget.php');
  }

  /**
   * Test callback.
   */
  public function testWithDependencies(): void {
    $input = [
      'foo',
      'Example',
      'foo_example',
      'ExampleWidget',
      'Yes',
      'Yes',
      'cron',
      'database',
      '',
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

     Would you like to inject dependencies? [No]:
     ➤ 

     Type the service name or use arrows up/down. Press enter to continue:
     ➤ 

     Type the service name or use arrows up/down. Press enter to continue:
     ➤ 

     Type the service name or use arrows up/down. Press enter to continue:
     ➤ 

     The following directories and files have been created or updated:
    –––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––
     • config/schema/foo.schema.yml
     • src/Plugin/Field/FieldWidget/ExampleWidget.php

    TXT;
    $this->assertDisplay($expected_display);

    $this->fixtureDir .= '/_w_deps';
    $this->assertGeneratedFile('config/schema/foo.schema.yml');
    $this->assertGeneratedFile('src/Plugin/Field/FieldWidget/ExampleWidget.php');
  }

}
