<?php

namespace DrupalCodeGenerator\Tests\Generator\Service;

use DrupalCodeGenerator\Tests\Generator\BaseGeneratorTest;

/**
 * Test for service:middleware command.
 */
final class MiddlewareTest extends BaseGeneratorTest {

  protected $class = 'Service\Middleware';

  protected $interaction = [
    'Module name [%default_name%]:' => 'Foo',
    'Module machine name [foo]:' => 'foo',
    'Class [FooMiddleware]:' => 'BarMiddleware',
  ];

  protected $fixtures = [
    'foo.services.yml' => '/_middleware.services.yml',
    'src/BarMiddleware.php' => '/_middleware.php',
  ];

}
