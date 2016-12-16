<?php

namespace DrupalCodeGenerator\Tests\Drupal_8\Service;

use DrupalCodeGenerator\Tests\GeneratorTestCase;

/**
 * Test for d8:service:middleware command.
 */
class MiddlewareTest extends GeneratorTestCase {

  /**
   * {@inheritdoc}
   */
  public function setUp() {
    $this->class = 'Drupal_8\Service\Middleware';
    $this->answers = [
      'Foo',
      'foo',
    ];
    $this->target = 'src/FooMiddleware.php';
    $this->fixture = __DIR__ . '/_middleware.php';

    parent::setUp();
  }

}
