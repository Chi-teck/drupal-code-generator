<?php

namespace DrupalCodeGenerator\Tests\Generator\Drupal_8\Plugin;

use DrupalCodeGenerator\Tests\Generator\BaseGeneratorTest;

/**
 * Test for d8:plugin:rest-resource command.
 */
class RestResourceGeneratorTest extends BaseGeneratorTest {

  protected $class = 'Drupal_8\Plugin\RestResource';

  protected $interaction = [
    'Module name [%default_name%]:' => 'Example',
    'Module machine name [example]:' => 'example',
    'Plugin label [Example]:' => 'Foo',
    'Plugin ID [example_foo]:' => 'example_foo',
    'Plugin class [FooResource]:' => 'FooResource',
  ];

  protected $fixtures = [
    'src/Plugin/rest/resource/FooResource.php' => __DIR__ . '/_rest_resource.php',
  ];

}
