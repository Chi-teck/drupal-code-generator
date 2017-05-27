<?php

namespace DrupalCodeGenerator\Tests\Generator\Drupal_8\Plugin;

use DrupalCodeGenerator\Tests\Generator\GeneratorTestCase;

/**
 * Test for d8:plugin:action command.
 */
class ActionTest extends GeneratorTestCase {

  protected $class = 'Drupal_8\Plugin\Action';

  protected $answers = [
    'Example',
    'example',
    'Foo',
    'example_foo',
    'Custom',
    'yes',
  ];

  protected $fixtures = [
    'src/Plugin/Action/Foo.php' => __DIR__ . '/_action.php',
  ];

}
