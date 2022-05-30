<?php declare(strict_types=1);

namespace DrupalCodeGenerator\Tests\Functional\Generator\Plugin;

use DrupalCodeGenerator\Command\Plugin\Action;
use DrupalCodeGenerator\Test\Functional\GeneratorTestBase;

/**
 * Tests plugin:action generator.
 */
final class ActionTest extends GeneratorTestBase {

  protected string $fixtureDir = __DIR__ . '/_action';

  public function testGenerator(): void {
    $input = [
      'example',
      'Foo',
      'example_foo',
      'Foo',
      'Custom',
      'yes',
    ];
    $this->execute(Action::class, $input);

    $expected_display = <<< 'TXT'

     Welcome to action generator!
    ––––––––––––––––––––––––––––––

     Module machine name [%default_name%]:
     ➤ 

     Action label [Update node title]:
     ➤ 

     Plugin ID [example_foo]:
     ➤ 

     Plugin class [Foo]:
     ➤ 

     Action category [Custom]:
     ➤ 

     Make the action configurable? [No]:
     ➤ 

     The following directories and files have been created or updated:
    –––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––
     • config/schema/example.schema.yml
     • src/Plugin/Action/Foo.php

    TXT;
    $this->assertDisplay($expected_display);

    $this->assertGeneratedFile('config/schema/example.schema.yml');
    $this->assertGeneratedFile('src/Plugin/Action/Foo.php');
  }

}
