<?php

namespace DrupalCodeGenerator\Tests\Generator\Plugin\Field;

use DrupalCodeGenerator\Tests\Generator\BaseGeneratorTest;

/**
 * Test for plugin:field:formatter command.
 */
final class FormatterTest extends BaseGeneratorTest {

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
    'config/schema/foo.schema.yml' => '/_formatter_schema.yml',
    'src/Plugin/Field/FieldFormatter/ZooFormatter.php' => '/_formatter.php',
  ];

}
