<?php declare(strict_types=1);

namespace DrupalCodeGenerator\Tests\Generator\Plugin;

use DrupalCodeGenerator\Tests\Generator\BaseGeneratorTest;

/**
 * Test for plugin:condition command.
 */
final class ConditionTest extends BaseGeneratorTest {

  protected string $class = 'Plugin\Condition';

  protected array $interaction = [
    'Module name [%default_name%]:' => 'Foo',
    'Module machine name [foo]:' => 'foo',
    'Plugin label [Example]:' => 'Example',
    'Plugin ID [foo_example]:' => 'foo_example',
    'Plugin class [Example]:' => 'Example',
  ];

  protected array $fixtures = [
    'config/schema/foo.schema.yml' => '/_condition_schema.yml',
    'src/Plugin/Condition/Example.php' => '/_condition.php',
  ];

}
