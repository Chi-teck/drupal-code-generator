<?php declare(strict_types=1);

namespace DrupalCodeGenerator\Tests\Functional\Generator;

use DrupalCodeGenerator\Command\InstallFile;
use DrupalCodeGenerator\Test\Functional\GeneratorTestBase;

/**
 * Tests install-file generator.
 */
final class InstallFileTest extends GeneratorTestBase {

  protected string $fixtureDir = __DIR__ . '/_install_file';

  public function testGenerator(): void {

    $this->execute(InstallFile::class, ['foo']);

    $expected_display = <<< 'TXT'

     Welcome to install-file generator!
    ––––––––––––––––––––––––––––––––––––

     Module machine name [%default_name%]:
     ➤ 

     The following directories and files have been created or updated:
    –––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––
     • foo.install

    TXT;
    $this->assertDisplay($expected_display);

    $this->assertGeneratedFile('foo.install');
  }

}
