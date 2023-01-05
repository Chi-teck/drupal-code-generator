<?php declare(strict_types = 1);

namespace DrupalCodeGenerator\Tests\Functional\Generator\Plugin\Field;

use DrupalCodeGenerator\Command\Plugin\Field\Type;
use DrupalCodeGenerator\Test\Functional\GeneratorTestBase;

/**
 * Tests plugin:field:type generator.
 */
final class TypeTest extends GeneratorTestBase {

  protected string $fixtureDir = __DIR__ . '/_type';

  /**
   * Test callback.
   */
  public function testWithoutConfig(): void {
    $input = [
      'example',
      'Foo',
      'foo',
      'FooItem',
      'No',
      'No',
    ];
    $this->execute(Type::class, $input);

    $expected_display = <<< 'TXT'

     Welcome to field-type generator!
    ––––––––––––––––––––––––––––––––––

     Module machine name:
     ➤ 

     Plugin label:
     ➤ 

     Plugin ID [example_foo]:
     ➤ 

     Plugin class [FooItem]:
     ➤ 

     Make the field storage configurable? [No]:
     ➤ 

     Make the field instance configurable? [No]:
     ➤ 

     The following directories and files have been created or updated:
    –––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––
     • config/schema/example.schema.yml
     • src/Plugin/Field/FieldType/FooItem.php

    TXT;
    $this->assertDisplay($expected_display);

    $this->fixtureDir .= '/_n_config';
    $this->assertGeneratedFile('config/schema/example.schema.yml');
    $this->assertGeneratedFile('src/Plugin/Field/FieldType/FooItem.php');
  }

  /**
   * Test callback.
   */
  public function testWithConfig(): void {
    $input = [
      'example',
      'Foo',
      'foo',
      'FooItem',
      'Yes',
      'Yes',
    ];
    $this->execute(Type::class, $input);

    $expected_display = <<< 'TXT'

     Welcome to field-type generator!
    ––––––––––––––––––––––––––––––––––

     Module machine name:
     ➤ 

     Plugin label:
     ➤ 

     Plugin ID [example_foo]:
     ➤ 

     Plugin class [FooItem]:
     ➤ 

     Make the field storage configurable? [No]:
     ➤ 

     Make the field instance configurable? [No]:
     ➤ 

     The following directories and files have been created or updated:
    –––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––
     • config/schema/example.schema.yml
     • src/Plugin/Field/FieldType/FooItem.php

    TXT;
    $this->assertDisplay($expected_display);

    $this->fixtureDir .= '/_w_config';
    $this->assertGeneratedFile('config/schema/example.schema.yml');
    $this->assertGeneratedFile('src/Plugin/Field/FieldType/FooItem.php');
  }

}
