<?php

namespace DrupalCodeGenerator\Tests\Generator\Plugin\Field;

use DrupalCodeGenerator\Tests\Generator\BaseGeneratorTest;

/**
 * Test for plugin:field:formatter command.
 */
class FormatterGeneratorTest extends BaseGeneratorTest {

  protected $class = 'Plugin\Field\Formatter';

  protected $interaction = [
    'Module name [%default_name%]:' => 'Foo',
    'Module machine name [foo]:' => 'foo',
    'Plugin label [Example]:' => 'Zoo',
    'Plugin ID [foo_zoo]:' => 'foo_zoo',
    'Plugin class [ZooFormatter]:' => 'ZooFormatter',
    'Make the formatter configurable? [No]:' => 'Yes',
  ];

  protected $fixtures = [
    'config/schema/foo.schema.yml' => __DIR__ . '/_formatter_schema.yml',
    'src/Plugin/Field/FieldFormatter/ZooFormatter.php' => __DIR__ . '/_formatter.php',
  ];

}
