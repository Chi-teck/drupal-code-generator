<?php declare(strict_types=1);

namespace DrupalCodeGenerator\Tests\Generator\Service;

use DrupalCodeGenerator\Tests\Generator\BaseGeneratorTest;

/**
 * Test for service:middleware command.
 */
final class MiddlewareTest extends BaseGeneratorTest {

  protected string $class = 'Service\Middleware';

  protected array $interaction = [
    'Module name [%default_name%]:' => 'Foo',
    'Module machine name [foo]:' => 'foo',
    'Class [FooMiddleware]:' => 'BarMiddleware',
  ];

  protected array $fixtures = [
    'foo.services.yml' => '/_middleware.services.yml',
    'src/BarMiddleware.php' => '/_middleware.php',
  ];

}
