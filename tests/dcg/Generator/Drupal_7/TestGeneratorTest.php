<?php

namespace DrupalCodeGenerator\Tests\Generator\Drupal_7;

use DrupalCodeGenerator\Tests\Generator\BaseGeneratorTest;

/**
 * Test for d7:test-file command.
 */
class TestGeneratorTest extends BaseGeneratorTest {

  protected $class = 'Drupal_7\Test';

  protected $interaction = [
    'Module name [%default_name%]:' => 'Example',
    'Module machine name [example]:' => 'example',
    'Class [ExampleTestCase]:' => 'ExampleTestCase',
  ];

  protected $fixtures = [
    'example.test' => __DIR__ . '/_.test',
  ];

}
