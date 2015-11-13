<?php

namespace DrupalCodeGenerator\Tests\Drupal_7;

use DrupalCodeGenerator\Tests\GeneratorTestCase;

/**
 * Test for d7:test-file command.
 */
class TestTest extends GeneratorTestCase {

  /**
   * {@inheritdoc}
   */
  public function setUp() {
    $this->class = 'Drupal_7\Test';
    $this->answers = [
      'Example',
      'example',
      'ExampleTestCase',
    ];

    $this->target = 'example.test';
    $this->fixture = __DIR__ . '/_.test';

    parent::setUp();
  }

}
