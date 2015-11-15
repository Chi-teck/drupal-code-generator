<?php

namespace DrupalCodeGenerator\Tests\Drupal_8;

use DrupalCodeGenerator\Tests\GeneratorTestCase;

/**
 * Test for d8:middleware command.
 */
class MiddlewareTest extends GeneratorTestCase {

  /**
   * {@inheritdoc}
   */
  public function setUp() {
    $this->class = 'Drupal_8\Middleware';
    $this->answers = [
      'Foo',
      'foo',
    ];
    $this->target = 'FooMiddleware.php';
    $this->fixture = __DIR__ . '/_middleware.php';

    parent::setUp();
  }

}
