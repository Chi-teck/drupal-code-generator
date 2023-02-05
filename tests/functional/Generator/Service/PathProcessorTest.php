<?php declare(strict_types = 1);

namespace DrupalCodeGenerator\Tests\Functional\Generator\Service;

use DrupalCodeGenerator\Command\Service\PathProcessor;
use DrupalCodeGenerator\Test\Functional\GeneratorTestBase;

/**
 * Tests service:path-processor generator.
 */
final class PathProcessorTest extends GeneratorTestBase {

  protected string $fixtureDir = __DIR__ . '/_path_processor';

  /**
   * Test callback.
   */
  public function testWithoutDependencies(): void {

    $this->execute(PathProcessor::class, ['example', 'PathProcessorExample']);

    $expected_display = <<< 'TXT'

     Welcome to path-processor generator!
    ––––––––––––––––––––––––––––––––––––––

     Module machine name:
     ➤ 

     Class [PathProcessorExample]:
     ➤ 

     Would you like to inject dependencies? [Yes]:
     ➤ 


     The following directories and files have been created or updated:
    –––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––
     • example.info.yml
     • example.services.yml
     • src/PathProcessor/PathProcessorExample.php

    TXT;
    $this->assertDisplay($expected_display);

    $this->assertGeneratedFile('example.services.yml', '_n_deps/example.services.yml');
    $this->assertGeneratedFile('src/PathProcessor/PathProcessorExample.php', '_n_deps/src/PathProcessor/PathProcessorExample.php');
  }

  /**
   * Test callback.
   */
  public function testWithDependencies(): void {

    $input = [
      'example',
      'PathProcessorExample',
      'Yes',
      'database',
      '',
    ];
    $this->execute(PathProcessor::class, $input);

    $expected_display = <<< 'TXT'

     Welcome to path-processor generator!
    ––––––––––––––––––––––––––––––––––––––

     Module machine name:
     ➤ 

     Class [PathProcessorExample]:
     ➤ 

     Would you like to inject dependencies? [Yes]:
     ➤ 

     Type the service name or use arrows up/down. Press enter to continue:
     ➤ 

     Type the service name or use arrows up/down. Press enter to continue:
     ➤ 

     The following directories and files have been created or updated:
    –––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––
     • example.info.yml
     • example.services.yml
     • src/PathProcessor/PathProcessorExample.php

    TXT;
    $this->assertDisplay($expected_display);

    $this->assertGeneratedFile('example.services.yml', '_w_deps/example.services.yml');
    $this->assertGeneratedFile('src/PathProcessor/PathProcessorExample.php', '_w_deps/src/PathProcessor/PathProcessorExample.php');
  }

}
