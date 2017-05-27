<?php

namespace DrupalCodeGenerator\Tests\Generator\Drupal_7;

use DrupalCodeGenerator\Tests\Generator\GeneratorTestCase;

/**
 * Test for d7:test-file command.
 */
class TestTest extends GeneratorTestCase {

  protected $class = 'Drupal_7\Test';

  protected $answers = [
    'Example',
    'example',
    'ExampleTestCase',
  ];

  protected $fixtures = [
    'example.test' => __DIR__ . '/_.test',
  ];

}
