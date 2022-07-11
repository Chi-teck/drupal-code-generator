<?php declare(strict_types = 1);

namespace DrupalCodeGenerator\Tests\Functional\Generator;

use DrupalCodeGenerator\Command\Module;
use DrupalCodeGenerator\Test\Functional\GeneratorTestBase;

/**
 * Tests module generator.
 */
final class ModuleTest extends GeneratorTestBase {

  protected string $fixtureDir = __DIR__ . '/_module';

  public function testGenerator(): void {

    $input = [
      'Foo',
      'foo',
      'Some description.',
      'Custom',
      'drupal:views',
      'Yes',
      'Yes',
      'Yes',
      'Yes',
      'Yes',
      'Yes',
      'Yes',
      'Yes',
    ];
    $this->execute(Module::class, $input);

    $expected_display = <<< 'TXT'

     Welcome to module generator!
    ––––––––––––––––––––––––––––––

     Module name:
     ➤ 

     Module machine name [foo]:
     ➤ 

     Module description [Provides additional functionality for the site.]:
     ➤ 

     Package [Custom]:
     ➤ 

     Dependencies (comma separated):
     ➤ 

     Would you like to create module file? [No]:
     ➤ 

     Would you like to create install file? [No]:
     ➤ 

     Would you like to create libraries.yml file? [No]:
     ➤ 

     Would you like to create permissions.yml file? [No]:
     ➤ 

     Would you like to create event subscriber? [No]:
     ➤ 

     Would you like to create block plugin? [No]:
     ➤ 

     Would you like to create a controller? [No]:
     ➤ 

     Would you like to create settings form? [No]:
     ➤ 

     The following directories and files have been created or updated:
    –––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––
     • foo/foo.info.yml
     • foo/foo.install
     • foo/foo.libraries.yml
     • foo/foo.links.menu.yml
     • foo/foo.module
     • foo/foo.permissions.yml
     • foo/foo.routing.yml
     • foo/foo.services.yml
     • foo/config/schema/foo.schema.yml
     • foo/src/Controller/FooController.php
     • foo/src/EventSubscriber/FooSubscriber.php
     • foo/src/Form/SettingsForm.php
     • foo/src/Plugin/Block/ExampleBlock.php

    TXT;
    $this->assertDisplay($expected_display);

    $this->assertGeneratedFile('foo/foo.info.yml');
    $this->assertGeneratedFile('foo/foo.install');
    $this->assertGeneratedFile('foo/foo.libraries.yml');
    $this->assertGeneratedFile('foo/foo.links.menu.yml');
    $this->assertGeneratedFile('foo/foo.module');
    $this->assertGeneratedFile('foo/foo.permissions.yml');
    $this->assertGeneratedFile('foo/foo.routing.yml');
    $this->assertGeneratedFile('foo/foo.services.yml');
    $this->assertGeneratedFile('foo/config/schema/foo.schema.yml');
    $this->assertGeneratedFile('foo/src/Controller/FooController.php');
    $this->assertGeneratedFile('foo/src/EventSubscriber/FooSubscriber.php');
    $this->assertGeneratedFile('foo/src/Form/SettingsForm.php');
    $this->assertGeneratedFile('foo/src/Plugin/Block/ExampleBlock.php');
  }

}
