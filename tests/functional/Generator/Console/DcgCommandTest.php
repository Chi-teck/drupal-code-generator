<?php declare(strict_types = 1);

namespace DrupalCodeGenerator\Tests\Generator\Console;

use DrupalCodeGenerator\Command\Console\DcgCommand;
use DrupalCodeGenerator\Test\Functional\GeneratorTestBase;

/**
 * Tests console:dcg-command generator.
 */
final class DcgCommandTest extends GeneratorTestBase {

  protected string $fixtureDir = __DIR__ . '/_dcg_command';

  public function testGenerator(): void {

    $input = [
      'custom:example',
      'Some description',
      'example',
    ];
    $this->execute(DcgCommand::class, $input);

    $expected_display = <<< 'TXT'

     Welcome to dcg-command generator!
    –––––––––––––––––––––––––––––––––––

     Command name [custom:example]:
     ➤ 

     Command description:
     ➤ 

     Command alias [example]:
     ➤ 

     The following directories and files have been created or updated:
    –––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––
     • custom/Example.php
     • custom/example.twig

    TXT;
    $this->assertDisplay($expected_display);

    $this->assertGeneratedFile('custom/Example.php');
    $this->assertGeneratedFile('custom/example.twig');
  }

}
