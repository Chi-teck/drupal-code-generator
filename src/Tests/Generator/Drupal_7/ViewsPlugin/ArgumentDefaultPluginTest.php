<?php

namespace DrupalCodeGenerator\Tests\Generator\Drupal_7\ViewsPlugin;

use DrupalCodeGenerator\Tests\Generator\GeneratorTestCase;

/**
 * Test for d7:views-plugin:argument-default command.
 */
class ArgumentDefaultTest extends GeneratorTestCase {

  protected $class = 'Drupal_7\ViewsPlugin\ArgumentDefault';

  protected $answers = [
    'Example',
    'example',
    'Foo',
    'foo',
  ];

  protected $fixtures = [
    'views_plugin_argument_foo.inc' => __DIR__ . '/_argument_default.inc',
  ];

}
