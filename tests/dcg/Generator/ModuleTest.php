<?php declare(strict_types=1);

namespace DrupalCodeGenerator\Tests\Generator;

/**
 * Test for module command.
 */
final class ModuleTest extends BaseGeneratorTest {

  protected $class = 'Module';
  protected $fixturePath = __DIR__ . '/_module/';

  protected $interaction = [
    'Module name [%default_name%]:' => 'Foo',
    'Module machine name [foo]:' => 'foo',
    'Module description [Provides additional functionality for the site.]:' => 'Some description.',
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
    'foo/foo.info.yml' => 'foo.info.yml',
    'foo/foo.install' => 'foo.install',
    'foo/foo.libraries.yml' => 'foo.libraries.yml',
    'foo/foo.links.menu.yml' => 'foo.links.menu.yml',
    'foo/foo.module' => 'foo.module',
    'foo/foo.permissions.yml' => 'foo.permissions.yml',
    'foo/foo.routing.yml' => 'foo.routing.yml',
    'foo/foo.services.yml' => 'foo.services.yml',
    'foo/config/schema/foo.schema.yml' => 'config/schema/foo.schema.yml',
    'foo/src/Controller/FooController.php' => 'src/Controller/FooController.php',
    'foo/src/EventSubscriber/FooSubscriber.php' => 'src/EventSubscriber/FooSubscriber.php',
    'foo/src/Form/SettingsForm.php' => 'src/Form/SettingsForm.php',
    'foo/src/Plugin/Block/ExampleBlock.php' => 'src/Plugin/Block/ExampleBlock.php',
  ];

}
