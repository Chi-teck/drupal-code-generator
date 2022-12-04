<?php declare(strict_types = 1);

namespace DrupalCodeGenerator\Tests\Functional\Generator\Plugin\Views;

use DrupalCodeGenerator\Command\Plugin\Views\Field;
use DrupalCodeGenerator\Test\Functional\GeneratorTestBase;

/**
 * Tests plugin:views:field generator.
 */
final class FieldTest extends GeneratorTestBase {

  protected string $fixtureDir = __DIR__ . '/_field';

  /**
   * Test callback.
   */
  public function testWithDependenciesAndWithConfig(): void {
    $input = [
      'foo',
      'Example',
      'foo_example',
      'Example',
      'Yes',
      'Yes',
      'entity_type.manager',
      '',
    ];
    $this->execute(Field::class, $input);

    $expected_display = <<< 'TXT'

     Welcome to views-field generator!
    –––––––––––––––––––––––––––––––––––

     Module machine name:
     ➤ 

     Plugin label:
     ➤ 

     Plugin ID [foo_example]:
     ➤ 

     Plugin class [Example]:
     ➤ 

     Make the plugin configurable? [No]:
     ➤ 

     Would you like to inject dependencies? [No]:
     ➤ 

     Type the service name or use arrows up/down. Press enter to continue:
     ➤ 

     Type the service name or use arrows up/down. Press enter to continue:
     ➤ 

     The following directories and files have been created or updated:
    –––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––
     • config/schema/foo.views.schema.yml
     • src/Plugin/views/field/Example.php

    TXT;
    $this->assertDisplay($expected_display);

    $this->fixtureDir .= '/_w_deps/_w_config';
    $this->assertGeneratedFile('config/schema/foo.views.schema.yml');
    $this->assertGeneratedFile('src/Plugin/views/field/Example.php');
  }

  /**
   * Test callback.
   */
  public function testWithoutDepsAndWithoutConfig(): void {
    $input = [
      'foo',
      'Example',
      'foo_example',
      'Example',
      'No',
      'No',
    ];
    $this->execute(Field::class, $input);

    $expected_display = <<< 'TXT'

     Welcome to views-field generator!
    –––––––––––––––––––––––––––––––––––

     Module machine name:
     ➤ 

     Plugin label:
     ➤ 

     Plugin ID [foo_example]:
     ➤ 

     Plugin class [Example]:
     ➤ 

     Make the plugin configurable? [No]:
     ➤ 

     Would you like to inject dependencies? [No]:
     ➤ 

     The following directories and files have been created or updated:
    –––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––
     • src/Plugin/views/field/Example.php

    TXT;
    $this->assertDisplay($expected_display);

    $this->fixtureDir .= '/_n_deps/_n_config';
    $this->assertGeneratedFile('src/Plugin/views/field/Example.php');
  }

}
