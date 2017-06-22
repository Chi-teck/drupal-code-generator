<?php

namespace DrupalCodeGenerator\Tests\Generator\Drupal_7\ViewsPlugin;

use DrupalCodeGenerator\Tests\Generator\GeneratorBaseTest;

/**
 * Test for d7:views-plugin:argument-default command.
 */
class ArgumentDefaultTest extends GeneratorBaseTest {

  protected $class = 'Drupal_7\ViewsPlugin\ArgumentDefault';

  protected $interaction = [
    'Module name [%default_name%]: ' => 'Example',
    'Module machine name [example]: ' => 'example',
    'Plugin name [Example]: ' => 'Foo',
    'Plugin machine name [foo]: ' => 'foo',
  ];

  protected $fixtures = [
    'views_plugin_argument_foo.inc' => __DIR__ . '/_argument_default.inc',
  ];

}
