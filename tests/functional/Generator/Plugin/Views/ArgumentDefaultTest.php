<?php declare(strict_types = 1);

namespace DrupalCodeGenerator\Tests\Functional\Generator\Plugin\Views;

use DrupalCodeGenerator\Command\Plugin\Views\ArgumentDefault;
use DrupalCodeGenerator\Test\Functional\GeneratorTestBase;

/**
 * Tests plugin:views:argument-default generator.
 */
final class ArgumentDefaultTest extends GeneratorTestBase {

  protected string $fixtureDir = __DIR__ . '/_argument_default';

  public function testGenerator(): void {
    $input = [
      'foo',
      'Example',
      'foo_example',
      'Example',
      'Yes',
      'Yes',
      'current_route_match',
      '',
    ];
    $this->execute(ArgumentDefault::class, $input);

    $expected_display = <<< 'TXT'

     Welcome to views-argument-default generator!
    ––––––––––––––––––––––––––––––––––––––––––––––

     Module machine name:
     ➤ 

     Plugin label [Example]:
     ➤ 

     Plugin ID [foo_example]:
     ➤ 

     Plugin class [Example]:
     ➤ 

     Make the plugin configurable? [No]:
     ➤ 

     Would you like to inject dependencies? [No]:
     ➤ 

     Type the service name or use arrows up/down. Press enter to continue:
     ➤ 

     Type the service name or use arrows up/down. Press enter to continue:
     ➤ 

     The following directories and files have been created or updated:
    –––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––
     • config/schema/foo.views.schema.yml
     • src/Plugin/views/argument_default/Example.php

    TXT;
    $this->assertDisplay($expected_display);

    $this->assertGeneratedFile('config/schema/foo.views.schema.yml');
    $this->assertGeneratedFile('src/Plugin/views/argument_default/Example.php');
  }

}
