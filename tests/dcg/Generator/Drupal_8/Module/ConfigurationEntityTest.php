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
    'Module name [%default_name%]: ' => 'Foo',
    'Module machine name [foo]: ' => 'foo',
    'Package [Custom]: ' => 'Custom',
    'Dependencies (comma separated): ' => 'drupal:views',
    'Entity type label [Foo]: ' => 'Example',
    'Entity type ID [example]: ' => 'example',
  ];

  protected $fixtures = [
    'foo/foo.info.yml' => __DIR__ . '/_configuration_entity/_info.yml',
    'foo/foo.links.action.yml' => NULL,
    'foo/foo.links.menu.yml' => NULL,
    'foo/foo.permissions.yml' => NULL,
    'foo/foo.routing.yml' => NULL,
    'foo/config/schema/foo.schema.yml' => NULL,
    'foo/src/Entity/Example.php' => NULL,
    'foo/src/ExampleInterface.php' => NULL,
    'foo/src/ExampleListBuilder.php' => NULL,
    'foo/src/Form/ExampleForm.php' => NULL,
  ];

}
