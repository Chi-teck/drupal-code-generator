<?php declare(strict_types=1);

namespace DrupalCodeGenerator\Tests\Generator\Service;

use DrupalCodeGenerator\Command\Service\Logger;
use DrupalCodeGenerator\Test\Functional\GeneratorTestBase;

/**
 * Tests service:logger generator.
 */
final class LoggerTest extends GeneratorTestBase {

  protected string $fixtureDir = __DIR__ . '/_logger';

  public function testGenerator(): void {

    $this->execute(new Logger(), ['foo', 'FileLog']);

    $expected_display = <<< 'TXT'

     Welcome to logger generator!
    ––––––––––––––––––––––––––––––

     Module machine name [%default_name%]:
     ➤ 

     Class [FileLog]:
     ➤ 

     The following directories and files have been created or updated:
    –––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––
     • foo.services.yml
     • src/Logger/FileLog.php

    TXT;
    $this->assertDisplay($expected_display);

    $this->assertGeneratedFile('foo.services.yml');
    $this->assertGeneratedFile('src/Logger/FileLog.php');
  }

}
