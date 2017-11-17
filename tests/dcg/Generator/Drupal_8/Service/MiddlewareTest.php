<?php

namespace DrupalCodeGenerator\Tests\Generator\Drupal_8\Service;

use DrupalCodeGenerator\Tests\Generator\GeneratorBaseTest;

/**
 * Test for d8:service:middleware command.
 */
class MiddlewareTest extends GeneratorBaseTest {

  protected $class = 'Drupal_8\Service\Middleware';

  protected $interaction = [
    'Module name [%default_name%]:' => 'Foo',
    'Module machine name [foo]:' => 'foo',
  ];

  protected $fixtures = [
    'foo.services.yml' => __DIR__ . '/_middleware.services.yml',
    'src/FooMiddleware.php' => __DIR__ . '/_middleware.php',
  ];

}
