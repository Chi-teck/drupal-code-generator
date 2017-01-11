<?php

namespace DrupalCodeGenerator\Tests\Drupal_8\Test;

use DrupalCodeGenerator\Tests\GeneratorTestCase;

/**
 * Test for d8:test command.
 */
class TestTest extends GeneratorTestCase {

  protected $class = 'Drupal_8\Test\Web';

  protected $answers = [
    'Foo',
    'foo',
    'Example',
  ];

  protected $fixtures = [
    'src/Tests/ExampleTest.php' => __DIR__ . '/_web.php',
  ];

}
