<?php

namespace DrupalCodeGenerator\Tests\Generator\Plugin;

use DrupalCodeGenerator\Tests\Generator\BaseGeneratorTest;

/**
 * Test for plugin:rest-resource command.
 */
class RestResourceTest extends BaseGeneratorTest {

  protected $class = 'Plugin\RestResource';

  protected $interaction = [
    'Module name [%default_name%]:' => 'Example',
    'Module machine name [example]:' => 'example',
    'Plugin label [Example]:' => 'Foo',
    'Plugin ID [example_foo]:' => 'example_foo',
    'Plugin class [FooResource]:' => 'FooResource',
  ];

  protected $fixtures = [
    'src/Plugin/rest/resource/FooResource.php' => '/_rest_resource.php',
  ];

}
