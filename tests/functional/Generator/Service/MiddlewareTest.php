<?php declare(strict_types = 1);

namespace DrupalCodeGenerator\Tests\Functional\Generator\Service;

use DrupalCodeGenerator\Command\Service\Middleware;
use DrupalCodeGenerator\Test\Functional\GeneratorTestBase;

/**
 * Tests service:middleware generator.
 */
final class MiddlewareTest extends GeneratorTestBase {

  protected string $fixtureDir = __DIR__ . '/_middleware';

  /**
   * Test callback.
   */
  public function testWithoutDependencies(): void {

    $this->execute(Middleware::class, ['foo', 'BarMiddleware', 'No']);

    $expected_display = <<< 'TXT'

     Welcome to middleware generator!
    ––––––––––––––––––––––––––––––––––

     Module machine name:
     ➤ 

     Class [FooMiddleware]:
     ➤ 

     Would you like to inject dependencies? [Yes]:
     ➤ 

     The following directories and files have been created or updated:
    –––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––
     • foo.services.yml
     • src/BarMiddleware.php

    TXT;
    $this->assertDisplay($expected_display);

    $this->assertGeneratedFile('foo.services.yml', 'n_deps/foo.services.yml');
    $this->assertGeneratedFile('src/BarMiddleware.php', 'n_deps/src/BarMiddleware.php');
  }

  /**
   * Test callback.
   */
  public function testWithtDependencies(): void {

    $input = [
      'foo',
      'BarMiddleware',
      'Yes',
      'entity_type.manager',
      '',
    ];
    $this->execute(Middleware::class, $input);

    $expected_display = <<< 'TXT'

     Welcome to middleware generator!
    ––––––––––––––––––––––––––––––––––

     Module machine name:
     ➤ 

     Class [FooMiddleware]:
     ➤ 

     Would you like to inject dependencies? [Yes]:
     ➤ 

     Type the service name or use arrows up/down. Press enter to continue:
     ➤ 

     Type the service name or use arrows up/down. Press enter to continue:
     ➤ 

     The following directories and files have been created or updated:
    –––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––
     • foo.services.yml
     • src/BarMiddleware.php

    TXT;
    $this->assertDisplay($expected_display);

    $this->assertGeneratedFile('foo.services.yml', 'w_deps/foo.services.yml');
    $this->assertGeneratedFile('src/BarMiddleware.php', 'w_deps/src/BarMiddleware.php');
  }

}
