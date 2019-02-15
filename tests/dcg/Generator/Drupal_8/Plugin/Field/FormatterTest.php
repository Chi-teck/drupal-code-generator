<?php

namespace DrupalCodeGenerator\Tests\Generator\Drupal_8\Plugin\Field;

use DrupalCodeGenerator\Tests\Generator\GeneratorBaseTest;

/**
 * Test for d8:plugin:field:formatter command.
 */
class FormatterTest extends GeneratorBaseTest {

  protected $class = 'Drupal_8\Plugin\Field\Formatter';

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
