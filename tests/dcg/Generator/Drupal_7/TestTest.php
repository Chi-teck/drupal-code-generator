<?php

namespace DrupalCodeGenerator\Tests\Generator\Drupal_7;

use DrupalCodeGenerator\Tests\Generator\GeneratorBaseTest;

/**
 * Test for d7:test-file command.
 */
class TestTest extends GeneratorBaseTest {

  protected $class = 'Drupal_7\Test';

  protected $interaction = [
    'Module name [%default_name%]: ' => 'Example',
    'Module machine name [example]: ' => 'example',
    'Class [ExampleTestCase]: ' => 'ExampleTestCase',
  ];

  protected $fixtures = [
    'example.test' => __DIR__ . '/_.test',
  ];

}
