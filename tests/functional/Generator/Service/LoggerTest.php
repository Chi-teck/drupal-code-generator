<?php declare(strict_types = 1);

namespace DrupalCodeGenerator\Tests\Functional\Generator\Service;

use DrupalCodeGenerator\Command\Service\Logger;
use DrupalCodeGenerator\Test\Functional\GeneratorTestBase;

/**
 * Tests service:logger generator.
 */
final class LoggerTest extends GeneratorTestBase {

  protected string $fixtureDir = __DIR__ . '/_logger';

  /**
   * Test callback.
   */
  public function testWithoutDependencies(): void {

    $this->execute(Logger::class, ['foo', 'ExampleLog', 'No']);

    $expected_display = <<< 'TXT'

     Welcome to logger generator!
    ––––––––––––––––––––––––––––––

     Module machine name:
     ➤ 

     Class:
     ➤ 

     Would you like to inject dependencies? [Yes]:
     ➤ 

     The following directories and files have been created or updated:
    –––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––
     • foo.services.yml
     • src/Logger/ExampleLog.php

    TXT;
    $this->assertDisplay($expected_display);

    $this->assertGeneratedFile('foo.services.yml', '_n_deps/foo.services.yml');
    $this->assertGeneratedFile('src/Logger/ExampleLog.php', '_n_deps/src/Logger/ExampleLog.php');
  }

  /**
   * Test callback.
   */
  public function testWithDependencies(): void {

    $input = [
      'foo',
      'ExampleLog',
      'Yes',
      'database',
      'entity_type.manager',
      '',
    ];
    $this->execute(Logger::class, $input);

    $expected_display = <<< 'TXT'

     Welcome to logger generator!
    ––––––––––––––––––––––––––––––

     Module machine name:
     ➤ 

     Class:
     ➤ 

     Would you like to inject dependencies? [Yes]:
     ➤ 

     Type the service name or use arrows up/down. Press enter to continue:
     ➤ 

     Type the service name or use arrows up/down. Press enter to continue:
     ➤ 

     Type the service name or use arrows up/down. Press enter to continue:
     ➤ 

     The following directories and files have been created or updated:
    –––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––
     • foo.services.yml
     • src/Logger/ExampleLog.php

    TXT;
    $this->assertDisplay($expected_display);

    $this->assertGeneratedFile('foo.services.yml', '_w_deps/foo.services.yml');
    $this->assertGeneratedFile('src/Logger/ExampleLog.php', '_w_deps/src/Logger/ExampleLog.php');
  }

}
