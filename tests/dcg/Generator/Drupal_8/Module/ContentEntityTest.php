<?php

namespace DrupalCodeGenerator\Tests\Generator\Drupal_8\Module;

use DrupalCodeGenerator\Tests\Generator\GeneratorBaseTest;

/**
 * Test for d8:module:content-entity command.
 *
 * @TODO: Create fixtures for this test.
 */
class ContentEntityTest extends GeneratorBaseTest {

  protected $class = 'Drupal_8\Module\ContentEntity';

  protected $interaction = [
    'Module name [%default_name%]: ' => 'Foo',
    'Module machine name [foo]: ' => 'foo',
    'Package [Custom]: ' => 'Custom',
    'Dependencies (comma separated): ' => 'drupal:views, drupal:fields, drupal:node',
    'Entity type label [Foo]: ' => 'Example',
    'Entity type ID [example]: ' => 'foo_example',
    'Entity base path [/admin/content/foo-example]: ' => '/example',
    'Make the entity type fieldable? [Yes]: ' => 'Yes',
    'Make the entity type revisionable? [No]: ' => 'Yes',
    'Create entity template? [Yes]: ' => 'Yes',
    'Create CRUD permissions? [No]: ' => 'No',
    'Add "title" base field? [Yes]: ' => 'Yes',
    'Add "status" base field? [Yes]: ' => 'Yes',
    'Add "created" base field? [Yes]: ' => 'Yes',
    'Add "changed" base field? [Yes]: ' => 'Yes',
    'Add "author" base field? [Yes]: ' => 'Yes',
    'Add "description" base field? [Yes]: ' => 'Yes',
    'Create REST configuration for the entity? [No]: ' => 'No',
  ];

  protected $fixtures = [
    'foo/foo.info.yml' => NULL,
    'foo/foo.links.action.yml' => NULL,
    'foo/foo.links.menu.yml' => NULL,
    'foo/foo.links.task.yml' => NULL,
    'foo/foo.module' => NULL,
    'foo/foo.permissions.yml' => NULL,
    'foo/foo.routing.yml' => NULL,
    'foo/src/Entity/Example.php' => NULL,
    'foo/src/ExampleInterface.php' => NULL,
    'foo/src/ExampleListBuilder.php' => NULL,
    'foo/src/Form/ExampleForm.php' => NULL,
    'foo/src/Form/ExampleSettingsForm.php' => NULL,
    'foo/templates/foo-example.html.twig' => NULL,
  ];

}
