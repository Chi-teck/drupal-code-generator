<?php declare(strict_types=1);

namespace DrupalCodeGenerator\Tests\Generator\Plugin\Field;

use DrupalCodeGenerator\Tests\Generator\BaseGeneratorTest;

/**
 * Test for plugin:field:formatter command.
 */
final class FormatterTest extends BaseGeneratorTest {

  protected string $class = 'Plugin\Field\Formatter';

  protected array $interaction = [
    'Module name [%default_name%]:' => 'Foo',
    'Module machine name [foo]:' => 'foo',
    'Plugin label [Example]:' => 'Zoo',
    'Plugin ID [foo_zoo]:' => 'foo_zoo',
    'Plugin class [ZooFormatter]:' => 'ZooFormatter',
    'Make the formatter configurable? [No]:' => 'Yes',
  ];

  protected array $fixtures = [
    'config/schema/foo.schema.yml' => '/_formatter_schema.yml',
    'src/Plugin/Field/FieldFormatter/ZooFormatter.php' => '/_formatter.php',
  ];

}
