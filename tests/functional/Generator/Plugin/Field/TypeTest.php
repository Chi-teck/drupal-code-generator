<?php declare(strict_types=1);

namespace DrupalCodeGenerator\Tests\Functional\Generator\Plugin\Field;

use DrupalCodeGenerator\Command\Plugin\Field\Type;
use DrupalCodeGenerator\Test\Functional\GeneratorTestBase;

/**
 * Tests plugin:field:type generator.
 */
final class TypeTest extends GeneratorTestBase {

  protected string $fixtureDir = __DIR__ . '/_type';

  public function testGenerator(): void {
    $input = [
      'example',
      'Foo',
      'foo',
      'FooItem',
      'Yes',
      'Yes',
    ];
    $this->execute(new Type(), $input);

    $expected_display = <<< 'TXT'

     Welcome to field-type generator!
    ––––––––––––––––––––––––––––––––––

     Module machine name [%default_name%]:
     ➤ 

     Plugin label [Example]:
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

    $this->assertGeneratedFile('config/schema/example.schema.yml');
    $this->assertGeneratedFile('src/Plugin/Field/FieldType/FooItem.php');
  }

}
