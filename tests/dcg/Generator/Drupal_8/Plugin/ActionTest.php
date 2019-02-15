<?php

namespace DrupalCodeGenerator\Tests\Generator\Drupal_8\Plugin;

use DrupalCodeGenerator\Tests\Generator\GeneratorBaseTest;

/**
 * Test for d8:plugin:action command.
 */
class ActionTest extends GeneratorBaseTest {

  protected $class = 'Drupal_8\Plugin\Action';

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
    'config/schema/example.schema.yml' => __DIR__ . '/_action_schema.yml',
    'src/Plugin/Action/Foo.php' => __DIR__ . '/_action.php',
  ];

}
