<?php

namespace DrupalCodeGenerator\Tests\Drupal_8;

use DrupalCodeGenerator\Tests\GeneratorTestCase;

/**
 * Test for d8:test command.
 */
class TestTest extends GeneratorTestCase {

  protected $class = 'Drupal_8\Test';

  protected $answers = [
    'Foo',
    'foo',
    'Example',
  ];

  protected $fixtures = [
    'ExampleTest.php' => __DIR__ . '/_test.php',
  ];

}
