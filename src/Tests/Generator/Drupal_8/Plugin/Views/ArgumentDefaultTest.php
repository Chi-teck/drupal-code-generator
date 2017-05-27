<?php

namespace DrupalCodeGenerator\Tests\Generator\Drupal_8\Plugin;

use DrupalCodeGenerator\Tests\Generator\GeneratorTestCase;

/**
 * Test for d8:plugin:views:argument-default command.
 */
class ArgumentDefaultTest extends GeneratorTestCase {

  protected $class = 'Drupal_8\Plugin\Views\ArgumentDefault';

  protected $answers = [
    'Foo',
    'foo',
    'Example',
    'foo_example',
  ];

  protected $fixtures = [
    'src/Plugin/views/argument_default/Example.php' => __DIR__ . '/_argument_default.php',
  ];

}
