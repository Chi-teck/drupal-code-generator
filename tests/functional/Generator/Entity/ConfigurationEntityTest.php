<?php declare(strict_types=1);

namespace DrupalCodeGenerator\Tests\Functional\Generator\Entity;

use DrupalCodeGenerator\Command\Entity\ConfigurationEntity;
use DrupalCodeGenerator\Test\Functional\GeneratorTestBase;

/**
 * Test configuration-entity generator.
 */
final class ConfigurationEntityTest extends GeneratorTestBase {

  protected string $fixtureDir = __DIR__ . '/_configuration_entity';

  public function testGenerator(): void {

    $input = ['foo', 'Foo', 'Example', 'example'];
    $this->execute(ConfigurationEntity::class, $input);

    $expected_display = <<< 'TXT'

     Welcome to config-entity generator!
    –––––––––––––––––––––––––––––––––––––

     Module machine name:
     ➤ 

     Module name [Foo]:
     ➤ 

     Entity type label [Foo]:
     ➤ 

     Entity type ID [example]:
     ➤ 

     The following directories and files have been created or updated:
    –––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––
     • foo.links.action.yml
     • foo.links.menu.yml
     • foo.permissions.yml
     • foo.routing.yml
     • config/schema/foo.schema.yml
     • src/ExampleInterface.php
     • src/ExampleListBuilder.php
     • src/Entity/Example.php
     • src/Form/ExampleForm.php

    TXT;
    $this->assertDisplay($expected_display);

    $this->assertGeneratedFile('foo.links.action.yml');
    $this->assertGeneratedFile('foo.links.menu.yml');
    $this->assertGeneratedFile('foo.permissions.yml');
    $this->assertGeneratedFile('foo.routing.yml');
    $this->assertGeneratedFile('config/schema/foo.schema.yml');
    $this->assertGeneratedFile('src/ExampleInterface.php');
    $this->assertGeneratedFile('src/ExampleListBuilder.php');
    $this->assertGeneratedFile('src/Entity/Example.php');
    $this->assertGeneratedFile('src/Form/ExampleForm.php');
  }

}
