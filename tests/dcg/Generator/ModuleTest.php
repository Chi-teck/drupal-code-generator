<?php

namespace DrupalCodeGenerator\Tests\Generator;

/**
 * Test for module command.
 */
class ModuleTest extends BaseGeneratorTest {

  protected $class = 'Module';

  protected $interaction = [
    'Module name [%default_name%]:' => 'Foo',
    'Module machine name [foo]:' => 'foo',
    'Module description:' => 'Some description.',
    'Package [Custom]:' => 'Custom',
    'Dependencies (comma separated):' => 'drupal:views',
    'Would you like to create module file? [No]:' => 'Yes',
    'Would you like to create install file? [No]:' => 'Yes',
    'Would you like to create libraries.yml file? [No]:' => 'Yes',
    'Would you like to create permissions.yml file? [No]:' => 'Yes',
    'Would you like to create event subscriber? [No]:' => 'Yes',
    'Would you like to create block plugin? [No]:' => 'Yes',
    'Would you like to create a controller? [No]:' => 'Yes',
    'Would you like to create settings form? [No]:' => 'Yes',
  ];

  protected $fixtures = [
    'foo/foo.info.yml' => __DIR__ . '/_module/foo.info.yml',
    'foo/foo.install' => __DIR__ . '/_module/foo.install',
    'foo/foo.libraries.yml' => __DIR__ . '/_module/foo.libraries.yml',
    'foo/foo.links.menu.yml' => __DIR__ . '/_module/foo.links.menu.yml',
    'foo/foo.module' => __DIR__ . '/_module/foo.module',
    'foo/foo.permissions.yml' => __DIR__ . '/_module/foo.permissions.yml',
    'foo/foo.routing.yml' => __DIR__ . '/_module/foo.routing.yml',
    'foo/foo.services.yml' => __DIR__ . '/_module/foo.services.yml',
    'foo/config/schema/foo.schema.yml' => __DIR__ . '/_module/config/schema/foo.schema.yml',
    'foo/src/Controller/FooController.php' => __DIR__ . '/_module/src/Controller/FooController.php',
    'foo/src/EventSubscriber/FooSubscriber.php' => __DIR__ . '/_module/src/EventSubscriber/FooSubscriber.php',
    'foo/src/Form/SettingsForm.php' => __DIR__ . '/_module/src/Form/SettingsForm.php',
    'foo/src/Plugin/Block/ExampleBlock.php' => __DIR__ . '/_module/src/Plugin/Block/ExampleBlock.php',
  ];

}
