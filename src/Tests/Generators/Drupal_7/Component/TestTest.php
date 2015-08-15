<?php

namespace DrupalCodeGenerator\Tests\Drupal_7\Component;

use DrupalCodeGenerator\Tests\GeneratorTestCase;

/**
 * Test for d7:component:test-file command.
 */
class TestTest extends GeneratorTestCase {

  /**
   * {@inheritdoc}
   */
  public function setUp() {
    $this->class = 'Drupal_7\Component\Test';
    $this->answers = [
      'Example',
      'example',
      'ExampleTestCase',
    ];

    $this->target = 'example.test';
    $this->fixture = __DIR__ . '/_' . $this->target;

    parent::setUp();
  }

}
