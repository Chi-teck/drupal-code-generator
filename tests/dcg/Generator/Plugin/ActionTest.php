<?php

namespace DrupalCodeGenerator\Tests\Generator\Plugin;

use DrupalCodeGenerator\Tests\Generator\BaseGeneratorTest;

/**
 * Test for plugin:action command.
 */
final class ActionTest extends BaseGeneratorTest {

  protected $class = 'Plugin\Action';

  protected $interaction = [
    'Module name [%default_name%]:' => 'Example',
    'Module machine name [example]:' => 'example',
    'Action label [Update node title]:' => 'Foo',
    'Plugin ID [example_foo]:' => 'example_foo',
    'Plugin class [Foo]:' => 'Foo',
    'Action category [Custom]:' => 'Custom',
    'Make the action configurable? [No]:' => 'yes',
  ];

  protected $fixtures = [
    'config/schema/example.schema.yml' => '/_action_schema.yml',
    'src/Plugin/Action/Foo.php' => '/_action.php',
  ];

}
