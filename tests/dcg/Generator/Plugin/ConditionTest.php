<?php

namespace DrupalCodeGenerator\Tests\Generator\Plugin;

use DrupalCodeGenerator\Tests\Generator\BaseGeneratorTest;

/**
 * Test for plugin:condition command.
 */
class ConditionTest extends BaseGeneratorTest {

  protected $class = 'Plugin\Condition';

  protected $interaction = [
    'Module name [%default_name%]:' => 'Foo',
    'Module machine name [foo]:' => 'foo',
    'Plugin label [Example]:' => 'Example',
    'Plugin ID [foo_example]:' => 'foo_example',
    'Plugin class [Example]:' => 'Example',
  ];

  protected $fixtures = [
    'config/schema/foo.schema.yml' => __DIR__ . '/_condition_schema.yml',
    'src/Plugin/Condition/Example.php' => __DIR__ . '/_condition.php',
  ];

}
