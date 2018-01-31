<?php

namespace DrupalCodeGenerator\Tests\Generator\Drupal_8\Module;

use DrupalCodeGenerator\Tests\Generator\GeneratorBaseTest;

/**
 * Test for d8:module:configuration-entity command.
 *
 * @TODO: Create fixtures for this test.
 */
class ConfigurationEntityTest extends GeneratorBaseTest {

  protected $class = 'Drupal_8\Module\ConfigurationEntity';

  protected $interaction = [
    'Module name [%default_name%]:' => 'Foo',
    'Module machine name [foo]:' => 'foo',
    'Package [Custom]:' => 'Custom',
    'Dependencies (comma separated):' => 'drupal:views',
    'Entity type label [Foo]:' => 'Example',
    'Entity type ID [example]:' => 'example',
  ];

  protected $fixtures = [
    'foo/foo.info.yml' => __DIR__ . '/_configuration_entity/foo.info.yml',
    'foo/foo.links.action.yml' => __DIR__ . '/_configuration_entity/foo.links.action.yml',
    'foo/foo.links.menu.yml' => __DIR__ . '/_configuration_entity/foo.links.menu.yml',
    'foo/foo.permissions.yml' => __DIR__ . '/_configuration_entity/foo.permissions.yml',
    'foo/foo.routing.yml' => __DIR__ . '/_configuration_entity/foo.routing.yml',
    'foo/config/schema/foo.schema.yml' => __DIR__ . '/_configuration_entity/config/schema/foo.schema.yml',
    'foo/src/Entity/Example.php' => __DIR__ . '/_configuration_entity/src/Entity/Example.php',
    'foo/src/ExampleInterface.php' => __DIR__ . '/_configuration_entity/src/ExampleInterface.php',
    'foo/src/ExampleListBuilder.php' => __DIR__ . '/_configuration_entity/src/ExampleListBuilder.php',
    'foo/src/Form/ExampleForm.php' => __DIR__ . '/_configuration_entity/src/Form/ExampleForm.php',
  ];

}
