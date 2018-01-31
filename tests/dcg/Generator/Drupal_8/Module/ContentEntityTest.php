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
    'Module name [%default_name%]:' => 'Foo',
    'Module machine name [foo]:' => 'foo',
    'Package [Custom]:' => 'Custom',
    'Dependencies (comma separated):' => 'drupal:views, drupal:fields, drupal:node',
    'Entity type label [Foo]:' => 'Example',
    'Entity type ID [example]:' => 'foo_example',
    'Entity base path [/admin/content/foo-example]:' => '/example',
    'Make the entity type fieldable? [Yes]:' => 'Yes',
    'Make the entity type revisionable? [No]:' => 'Yes',
    'Create entity template? [Yes]:' => 'Yes',
    'Create CRUD permissions? [No]:' => 'No',
    'Add "title" base field? [Yes]:' => 'Yes',
    'Add "status" base field? [Yes]:' => 'Yes',
    'Add "created" base field? [Yes]:' => 'Yes',
    'Add "changed" base field? [Yes]:' => 'Yes',
    'Add "author" base field? [Yes]:' => 'Yes',
    'Add "description" base field? [Yes]:' => 'Yes',
    'Create REST configuration for the entity? [No]:' => 'No',
  ];

  protected $fixtures = [
    'foo/foo.info.yml' => __DIR__ . '/_content_entity/foo.info.yml',
    'foo/foo.links.action.yml' => __DIR__ . '/_content_entity/foo.links.action.yml',
    'foo/foo.links.menu.yml' => __DIR__ . '/_content_entity/foo.links.menu.yml',
    'foo/foo.links.task.yml' => __DIR__ . '/_content_entity/foo.links.task.yml',
    'foo/foo.module' => __DIR__ . '/_content_entity/foo.module',
    'foo/foo.permissions.yml' => __DIR__ . '/_content_entity/foo.permissions.yml',
    'foo/foo.routing.yml' => __DIR__ . '/_content_entity/foo.routing.yml',
    'foo/src/Entity/Example.php' => __DIR__ . '/_content_entity/src/Entity/Example.php',
    'foo/src/ExampleInterface.php' => __DIR__ . '/_content_entity/src/ExampleInterface.php',
    'foo/src/ExampleListBuilder.php' => __DIR__ . '/_content_entity/src/ExampleListBuilder.php',
    'foo/src/Form/ExampleForm.php' => __DIR__ . '/_content_entity/src/Form/ExampleForm.php',
    'foo/src/Form/ExampleSettingsForm.php' => __DIR__ . '/_content_entity/src/Form/ExampleSettingsForm.php',
    'foo/templates/foo-example.html.twig' => __DIR__ . '/_content_entity/templates/foo-example.html.twig',
  ];

}
