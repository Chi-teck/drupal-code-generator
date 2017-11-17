<?php

namespace DrupalCodeGenerator\Tests\Generator\Drupal_8\Module;

use DrupalCodeGenerator\Tests\Generator\GeneratorBaseTest;

/**
 * Test for d8:module:standard command.
 */
class StandardTest extends GeneratorBaseTest {

  protected $class = 'Drupal_8\Module\Standard';

  protected $interaction = [
    'Module name [%default_name%]:' => 'Foo',
    'Module machine name [foo]:' => 'foo',
    'Module description [The description.]:' => 'Some description.',
    'Package [Custom]:' => 'Custom',
    'Dependencies (comma separated):' => 'drupal:views',
    'Would you like to create install file? [Yes]:' => 'Yes',
    'Would you like to create libraries.yml file? [Yes]:' => 'Yes',
    'Would you like to create permissions.yml file? [Yes]:' => 'Yes',
    'Would you like to create event subscriber? [Yes]:' => 'Yes',
    'Would you like to create block plugin? [Yes]:' => 'Yes',
    'Would you like to create a controller? [Yes]:' => 'Yes',
    'Would you like to create settings form? [Yes]:' => 'Yes',
  ];

  protected $fixtures = [
    'foo/foo.info.yml' => NULL,
    'foo/foo.install' => NULL,
    'foo/foo.libraries.yml' => NULL,
    'foo/foo.module' => NULL,
    'foo/foo.permissions.yml' => NULL,
    'foo/foo.routing.yml' => NULL,
    'foo/foo.services.yml' => NULL,
    'foo/src/Controller/FooController.php' => NULL,
    'foo/src/EventSubscriber/FooSubscriber.php' => NULL,
    'foo/src/Form/SettingsForm.php' => NULL,
    'foo/src/Plugin/Block/ExampleBlock.php' => NULL,
  ];

}
