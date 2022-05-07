<?php declare(strict_types=1);

namespace DrupalCodeGenerator\Tests\Functional\Generator\Service;

use DrupalCodeGenerator\Command\Service\Middleware;
use DrupalCodeGenerator\Test\Functional\GeneratorTestBase;

/**
 * Tests service:middleware generator.
 */
final class MiddlewareTest extends GeneratorTestBase {

  protected string $fixtureDir = __DIR__ . '/_middleware';

  public function testGenerator(): void {

    $this->execute(new Middleware(), ['foo', 'BarMiddleware']);

    $expected_display = <<< 'TXT'

     Welcome to middleware generator!
    ––––––––––––––––––––––––––––––––––

     Module machine name [%default_name%]:
     ➤ 

     Class [FooMiddleware]:
     ➤ 

     The following directories and files have been created or updated:
    –––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––
     • foo.services.yml
     • src/BarMiddleware.php

    TXT;
    $this->assertDisplay($expected_display);

    $this->assertGeneratedFile('foo.services.yml');
    $this->assertGeneratedFile('src/BarMiddleware.php');
  }

}
