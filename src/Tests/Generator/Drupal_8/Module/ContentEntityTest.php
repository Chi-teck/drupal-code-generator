<?php

namespace DrupalCodeGenerator\Tests\Generator\Drupal_8\Module;

use DrupalCodeGenerator\Tests\Generator\GeneratorTestCase;

/**
 * Test for d8:module:content-entity command.
 *
 * @TODO: Create fixtures for this test.
 */
class ContentEntityTest extends GeneratorTestCase {

  protected $class = 'Drupal_8\Module\ContentEntity';

  protected $answers = [
    'Foo',
    'foo',
    'Custom',
    '8.x-1.0',
    'views, fields, node',
    'Example',
    'foo_example',
    '/example',
    TRUE,
    TRUE,
    TRUE,
    FALSE,
    TRUE,
    TRUE,
    TRUE,
    TRUE,
    TRUE,
    TRUE,
    FALSE,
  ];

  protected $fixtures = [
    'foo/foo.info.yml' => NULL,
    'foo/foo.links.action.yml' => NULL,
    'foo/foo.links.menu.yml' => NULL,
    'foo/foo.links.task.yml' => NULL,
    'foo/foo.permissions.yml' => NULL,
    'foo/foo.routing.yml' => NULL,
    'foo/src/Entity/Example.php' => NULL,
    'foo/src/ExampleInterface.php' => NULL,
    'foo/src/ExampleListBuilder.php' => NULL,
    'foo/src/Form/ExampleForm.php' => NULL,
    'foo/src/Form/ExampleSettingsForm.php' => NULL,
    'foo/templates/foo-example.html.twig' => NULL,
    'foo/foo.module' => NULL,
  ];

}
