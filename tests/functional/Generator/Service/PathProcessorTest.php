<?php declare(strict_types = 1);

namespace DrupalCodeGenerator\Tests\Functional\Generator\Service;

use DrupalCodeGenerator\Command\Service\PathProcessor;
use DrupalCodeGenerator\Test\Functional\GeneratorTestBase;

/**
 * Tests service:path-processor generator.
 */
final class PathProcessorTest extends GeneratorTestBase {

  protected string $fixtureDir = __DIR__ . '/_path_processor';

  public function testGenerator(): void {

    $this->execute(PathProcessor::class, ['example', 'PathProcessorExample']);

    $expected_display = <<< 'TXT'

     Welcome to path-processor generator!
    ––––––––––––––––––––––––––––––––––––––

     Module machine name:
     ➤ 

     Class [PathProcessorExample]:
     ➤ 

     The following directories and files have been created or updated:
    –––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––
     • example.services.yml
     • src/PathProcessor/PathProcessorExample.php

    TXT;
    $this->assertDisplay($expected_display);

    $this->assertGeneratedFile('example.services.yml');
    $this->assertGeneratedFile('src/PathProcessor/PathProcessorExample.php');
  }

}
