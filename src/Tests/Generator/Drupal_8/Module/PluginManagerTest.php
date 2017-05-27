<?php

namespace DrupalCodeGenerator\Tests\Generator\Drupal_8\Module;

use DrupalCodeGenerator\Tests\Generator\GeneratorTestCase;

/**
 * Test for d8:module:plugin-manager command.
 *
 * @TODO: Create fixtures for this test.
 */
class PluginManagerTest extends GeneratorTestCase {

  protected $class = 'Drupal_8\Module\PluginManager';

  protected $answers = [
    'Foo',
    'foo',
    'Foo description',
    'custom',
    '8.x-1.0',
    'views, fields, node',
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
