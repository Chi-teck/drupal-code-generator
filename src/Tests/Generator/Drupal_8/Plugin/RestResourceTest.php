<?php

namespace DrupalCodeGenerator\Tests\Generator\Drupal_8\Plugin;

use DrupalCodeGenerator\Tests\Generator\GeneratorTestCase;

/**
 * Test for d8:plugin:rest-resource command.
 */
class RestResourceTest extends GeneratorTestCase {

  protected $class = 'Drupal_8\Plugin\RestResource';

  protected $answers = [
    'Example',
    'example',
    'Foo',
    'example_foo',
  ];

  protected $fixtures = [
    'src/Plugin/rest/resource/FooResource.php' => __DIR__ . '/_rest_resource.php',
  ];

}
