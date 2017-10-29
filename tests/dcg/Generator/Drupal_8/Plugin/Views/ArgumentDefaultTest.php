<?php

namespace DrupalCodeGenerator\Tests\Generator\Drupal_8\Plugin\Views;

use DrupalCodeGenerator\Tests\Generator\GeneratorBaseTest;

/**
 * Test for d8:plugin:views:argument-default command.
 */
class ArgumentDefaultTest extends GeneratorBaseTest {

  protected $class = 'Drupal_8\Plugin\Views\ArgumentDefault';

  protected $interaction = [
    'Module name [%default_name%]: ' => 'Foo',
    'Module machine name [foo]: ' => 'foo',
    'Plugin label [Example]: ' => 'Example',
    'Plugin ID [foo_example]: ' => 'foo_example',
  ];

  protected $fixtures = [
    'src/Plugin/views/argument_default/Example.php' => __DIR__ . '/_argument_default.php',
  ];

}
