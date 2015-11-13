<?php

namespace DrupalCodeGenerator\Tests\Drupal_8;

use DrupalCodeGenerator\Tests\GeneratorTestCase;

/**
 * Test for d8:test command.
 */
class TestTest extends GeneratorTestCase {

  /**
   * {@inheritdoc}
   */
  public function setUp() {
    $this->class = 'Drupal_8\Test';
    $this->answers = [
      'Foo',
      'foo',
      'Example',
    ];
    $this->target = 'ExampleTest.php';
    $this->fixture = __DIR__ . '/_test.php';

    parent::setUp();
  }

}
