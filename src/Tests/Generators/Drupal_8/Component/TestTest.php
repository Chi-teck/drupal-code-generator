<?php

namespace DrupalCodeGenerator\Tests\Drupal_8\Component\Plugin;

use DrupalCodeGenerator\Tests\GeneratorTestCase;

/**
 * Test for d8:component:test command.
 */
class Test extends GeneratorTestCase {

  /**
   * {@inheritdoc}
   */
  public function setUp() {
    $this->class = 'Drupal_8\Component\Test';
    $this->answers = [
      'Foo',
      'foo',
      'Example',
    ];
    $this->target = 'ExampleTest.php';
    $this->fixture = __DIR__ . '/_test_' . $this->target;

    // Add suffix to prevent phpunit from loading this file.
    $this->fixture .= '_';

    parent::setUp();
  }

}
