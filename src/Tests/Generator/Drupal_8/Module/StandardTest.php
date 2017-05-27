<?php

namespace DrupalCodeGenerator\Tests\Generator\Drupal_8\Module;

use DrupalCodeGenerator\Tests\Generator\GeneratorTestCase;

/**
 * Test for d8:module:standard command.
 */
class StandardTest extends GeneratorTestCase {

  protected $class = 'Drupal_8\Module\Standard';

  protected $answers = [
    'Foo',
    'foo',
    'Description',
    'Custom',
    '8.x-1.0',
  ];

  protected $fixtures = [
    'foo/foo.info.yml' => NULL,
    'foo/foo.module' => NULL,
    'foo/foo.install' => NULL,
    'foo/foo.libraries.yml' => NULL,
    'foo/foo.services.yml' => NULL,
    'foo/foo.permissions.yml' => NULL,
    'foo/js/foo.js' => NULL,
    'foo/src/FooExample.php' => NULL,
    'foo/src/FooMiddleware.php' => NULL,
    'foo/src/EventSubscriber/FooSubscriber.php' => NULL,
    'foo/src/Plugin/Block/ExampleBlock.php' => NULL,
    'foo/foo.routing.yml' => NULL,
    'foo/src/Controller/FooController.php' => NULL,
    'foo/src/Form/SettingsForm.php' => NULL,
  ];

}
