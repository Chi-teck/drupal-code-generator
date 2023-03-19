<?php declare(strict_types = 1);

namespace DrupalCodeGenerator\Tests\Generator\Console;

use DrupalCodeGenerator\Command\Console\DcgCommand;
use DrupalCodeGenerator\Test\Functional\GeneratorTestBase;

/**
 * Tests console:dcg-command generator.
 */
final class DcgCommandTest extends GeneratorTestBase {

  protected string $fixtureDir = __DIR__ . '/_dcg_command';

  /**
   * Test callback.
   */
  public function testGenerator(): void {

    $input = [
      'example',
      'Example',
      'example:foo-bar',
      'Example generator.',
      'FooBarGenerator',
      'example',
      'example',
    ];
    $this->execute(DcgCommand::class, $input);

    $expected_display = <<< 'TXT'

     Welcome to dcg-command generator!
    –––––––––––––––––––––––––––––––––––

     Module machine name:
     ➤ 

     Module name [Example]:
     ➤ 

     Generator name [example:example]:
     ➤ 

     Generator description:
     ➤ 

     Class [FooBar]:
     ➤ 

     The following directories and files have been created or updated:
    –––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––
     • drush.services.yml
     • example.info.yml
     • src/Generator/FooBarGenerator.php
     • templates/generator/foo-bar.twig

    TXT;
    $this->assertDisplay($expected_display);

    $this->assertGeneratedFile('drush.services.yml');
    $this->assertGeneratedFile('example.info.yml');
    $this->assertGeneratedFile('src/Generator/FooBarGenerator.php');
    $this->assertGeneratedFile('templates/generator/foo-bar.twig');
  }

}
