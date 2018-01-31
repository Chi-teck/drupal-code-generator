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
    'Description [Module description.]:' => 'Foo description.',
    'Package [Custom]:' => 'Custom',
    'Dependencies (comma separated):' => 'drupal:views, drupal:field, drupal:node',
  ];

  protected $fixtures = [
    'foo/foo.drush.inc' => __DIR__ . '/_plugin_manager/foo.drush.inc',
    'foo/foo.info.yml' => __DIR__ . '/_plugin_manager/foo.info.yml',
    'foo/foo.services.yml' => __DIR__ . '/_plugin_manager/foo.services.yml',
    'foo/src/Annotation/Foo.php' => __DIR__ . '/_plugin_manager/src/Annotation/Foo.php',
    'foo/src/FooInterface.php' => __DIR__ . '/_plugin_manager/src/FooInterface.php',
    'foo/src/FooPluginBase.php' => __DIR__ . '/_plugin_manager/src/FooPluginBase.php',
    'foo/src/FooPluginManager.php' => __DIR__ . '/_plugin_manager/src/FooPluginManager.php',
    'foo/src/Plugin/Foo/Example.php' => __DIR__ . '/_plugin_manager/src/Plugin/Foo/Example.php',
  ];

}
