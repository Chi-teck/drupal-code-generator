<?php

namespace DrupalCodeGenerator\Tests\Generator\Drupal_8\Module;

use DrupalCodeGenerator\Tests\Generator\GeneratorBaseTest;

/**
 * Test for d8:module:plugin-manager command.
 *
 * @todo Create fixtures for this test.
 */
class PluginManagerTest extends GeneratorBaseTest {

  protected $class = 'Drupal_8\Module\PluginManager';

  protected $interaction = [
    'Module name [%default_name%]:' => 'Foo',
    'Module machine name [foo]:' => 'foo',
    'Description [Module description.]:' => 'Foo description',
    'Package [Custom]:' => 'Custom',
    'Dependencies (comma separated):' => 'views, fields, node',
  ];

  protected $fixtures = [
    'foo/foo.drush.inc' => NULL,
    'foo/foo.info.yml' => NULL,
    'foo/foo.services.yml' => NULL,
    'foo/src/Annotation/Foo.php' => NULL,
    'foo/src/FooInterface.php' => NULL,
    'foo/src/FooPluginBase.php' => NULL,
    'foo/src/FooPluginManager.php' => NULL,
    'foo/src/Plugin/Foo/Example.php' => NULL,
  ];

}
