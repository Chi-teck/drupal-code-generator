<?php

namespace DrupalCodeGenerator\Tests\Generator\Drupal_8\Module;

use DrupalCodeGenerator\Tests\Generator\GeneratorTestCase;

/**
 * Test for d8:module:configuration-entity command.
 *
 * @TODO: Create fixtures for this test.
 */
class ConfigurationEntityTest extends GeneratorTestCase {

  protected $class = 'Drupal_8\Module\ConfigurationEntity';

  protected $answers = [
    'Foo',
    'foo',
    'Custom',
    '8.x-1.0',
    'views',
    'Example',
    'example',
  ];

  protected $fixtures = [
    'foo/foo.info.yml' => __DIR__ . '/_configuration_entity/_info.yml',
    'foo/src/Controller/ExampleListBuilder.php' => NULL,
    'foo/src/Form/ExampleForm.php' => NULL,
    'foo/src/Form/ExampleDeleteForm.php' => NULL,
    'foo/src/ExampleInterface.php' => NULL,
    'foo/src/Entity/Example.php' => NULL,
    'foo/foo.routing.yml' => NULL,
    'foo/foo.links.action.yml' => NULL,
    'foo/foo.links.menu.yml' => NULL,
    'foo/foo.permissions.yml' => NULL,
    'foo/config/schema/foo.schema.yml' => NULL,
  ];

}
