<?php

namespace DrupalCodeGenerator\Tests\Generator;

/**
 * Test for configuration-entity command.
 */
class ConfigurationEntityTest extends BaseGeneratorTest {

  protected $class = 'ConfigurationEntity';

  protected $interaction = [
    'Module name [%default_name%]:' => 'Foo',
    'Module machine name [foo]:' => 'foo',
    'Entity type label [Foo]:' => 'Example',
    'Entity type ID [example]:' => 'example',
  ];

  protected $fixtures = [
    'foo.links.action.yml' => __DIR__ . '/_configuration_entity/foo.links.action.yml',
    'foo.links.menu.yml' => __DIR__ . '/_configuration_entity/foo.links.menu.yml',
    'foo.permissions.yml' => __DIR__ . '/_configuration_entity/foo.permissions.yml',
    'foo.routing.yml' => __DIR__ . '/_configuration_entity/foo.routing.yml',
    'src/ExampleInterface.php' => __DIR__ . '/_configuration_entity/src/ExampleInterface.php',
    'src/ExampleListBuilder.php' => __DIR__ . '/_configuration_entity/src/ExampleListBuilder.php',
    'config/schema/foo.schema.yml' => __DIR__ . '/_configuration_entity/config/schema/foo.schema.yml',
    'src/Entity/Example.php' => __DIR__ . '/_configuration_entity/src/Entity/Example.php',
    'src/Form/ExampleForm.php' => __DIR__ . '/_configuration_entity/src/Form/ExampleForm.php',
  ];

}
