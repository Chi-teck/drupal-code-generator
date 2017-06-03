<?php

namespace DrupalCodeGenerator\Tests\Generator\Drupal_8\Service;

use DrupalCodeGenerator\Tests\Generator\GeneratorTestCase;

/**
 * Test for d8:service:middleware command.
 */
class MiddlewareTest extends GeneratorTestCase {

  protected $class = 'Drupal_8\Service\Middleware';

  protected $answers = [
    'Foo',
    'foo',
  ];

  protected $fixtures = [
    'src/FooMiddleware.php' => __DIR__ . '/_middleware.php',
    'foo.services.yml' => __DIR__ . '/_middleware.services.yml',
  ];

}
