<?php declare(strict_types=1);

namespace DrupalCodeGenerator\Tests\Generator\Plugin\Field;

use DrupalCodeGenerator\Tests\Generator\BaseGeneratorTest;

/**
 * Test for plugin:field:type command.
 */
final class TypeTest extends BaseGeneratorTest {

  protected string $class = 'Plugin\Field\Type';

  protected array $interaction = [
    'Module name [%default_name%]:' => 'Example',
    'Module machine name [example]:' => 'example',
    'Plugin label [Example]:' => 'Foo',
    'Plugin ID [example_foo]:' => 'foo',
    'Plugin class [FooItem]:' => 'FooItem',
    'Make the field storage configurable? [No]:' => 'Yes',
    'Make the field instance configurable? [No]:' => 'Yes',
  ];

  protected array $fixtures = [
    'config/schema/example.schema.yml' => '/_type_schema.yml',
    'src/Plugin/Field/FieldType/FooItem.php' => '/_type.php',
  ];

}
