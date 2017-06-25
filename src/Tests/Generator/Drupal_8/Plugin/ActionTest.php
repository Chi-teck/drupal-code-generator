<?php

namespace DrupalCodeGenerator\Tests\Generator\Drupal_8\Plugin;

use DrupalCodeGenerator\Tests\Generator\GeneratorBaseTest;

/**
 * Test for d8:plugin:action command.
 */
class ActionTest extends GeneratorBaseTest {

  protected $class = 'Drupal_8\Plugin\Action';

  protected $interaction = [
    'Module name [%default_name%]: ' => 'Example',
    'Module machine name [example]: ' => 'example',
    'Plugin label [Example]: ' => 'Foo',
    'Plugin ID [example_foo]: ' => 'example_foo',
    'Action category [Custom]: ' => 'Custom',
    'Make the action configurable? [No]: ' => 'yes',
  ];

  protected $fixtures = [
    'src/Plugin/Action/Foo.php' => __DIR__ . '/_action.php',
  ];

}
