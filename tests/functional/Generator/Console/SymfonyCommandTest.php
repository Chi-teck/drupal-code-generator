<?php declare(strict_types=1);

namespace DrupalCodeGenerator\Tests\Functional\Generator;

use DrupalCodeGenerator\Command\Console\SymfonyCommand;
use DrupalCodeGenerator\Test\Functional\GeneratorTestBase;

/**
 * Tests console:symfony-command generator.
 */
final class SymfonyCommandTest extends GeneratorTestBase {

  protected string $fixtureDir = __DIR__ . '/_symfony_command';

  public function testGenerator(): void {

    $input = [
      'foo',
      'foo:bar',
      'Example command.',
      'bar',
      'BarCommand',
      'Yes',
    ];
    $this->execute(new SymfonyCommand(), $input);

    $expected_display = <<< 'TXT'

     Welcome to symfony-command generator!
    –––––––––––––––––––––––––––––––––––––––

     Module machine name [%default_name%]:
     ➤ 

     Command name [foo:example]:
     ➤ 

     Command description:
     ➤ 

     Command alias [bar]:
     ➤ 

     Class [BarCommand]:
     ➤ 

     Would you like to run the command with Drush [Yes]:
     ➤ 

     The following directories and files have been created or updated:
    –––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––
     • drush.services.yml
     • src/Command/BarCommand.php

    TXT;
    $this->assertDisplay($expected_display);

    $this->assertGeneratedFile('drush.services.yml');
    $this->assertGeneratedFile('src/Command/BarCommand.php');
  }

}
