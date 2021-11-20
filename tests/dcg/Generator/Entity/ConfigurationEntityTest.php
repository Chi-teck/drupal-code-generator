<?php declare(strict_types=1);

namespace DrupalCodeGenerator\Tests\Generator\Entity;

use DrupalCodeGenerator\Command\Entity\ConfigurationEntity;
use DrupalCodeGenerator\Test\GeneratorTest;

/**
 * Test for configuration-entity command.
 */
final class ConfigurationEntityTest extends GeneratorTest {

  protected string $fixtureDir = __DIR__;

  /**
   * Test callback.
   */
  public function testGenerator(): void {

    $this->execute(new ConfigurationEntity(), ['Foo', 'foo', 'Example', 'example']);

    $expected_display = <<< 'TXT'

     Welcome to config-entity generator!
    –––––––––––––––––––––––––––––––––––––

     Module name [%default_name%]:
     ➤ 

     Module machine name [foo]:
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

    $this->assertGeneratedFile('foo.links.action.yml', '/_configuration_entity/foo.links.action.yml');
    $this->assertGeneratedFile('foo.links.menu.yml', '/_configuration_entity/foo.links.menu.yml');
    $this->assertGeneratedFile('foo.permissions.yml', '/_configuration_entity/foo.permissions.yml');
    $this->assertGeneratedFile('foo.routing.yml', '/_configuration_entity/foo.routing.yml');
    $this->assertGeneratedFile('config/schema/foo.schema.yml', '/_configuration_entity/config/schema/foo.schema.yml');
    $this->assertGeneratedFile('src/ExampleInterface.php', '/_configuration_entity/src/ExampleInterface.php');
    $this->assertGeneratedFile('src/ExampleListBuilder.php', '/_configuration_entity/src/ExampleListBuilder.php');
    $this->assertGeneratedFile('src/Entity/Example.php', '/_configuration_entity/src/Entity/Example.php');
    $this->assertGeneratedFile('src/Form/ExampleForm.php', '/_configuration_entity/src/Form/ExampleForm.php');
  }

}
