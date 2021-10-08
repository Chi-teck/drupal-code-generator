<?php declare(strict_types=1);

namespace DrupalCodeGenerator\Tests\Generator\Plugin;

use DrupalCodeGenerator\Tests\Generator\BaseGeneratorTest;

/**
 * Test for plugin:rest-resource command.
 */
final class RestResourceTest extends BaseGeneratorTest {

  protected string $class = 'Plugin\RestResource';

  protected array $interaction = [
    'Module name [%default_name%]:' => 'Example',
    'Module machine name [example]:' => 'example',
    'Plugin label [Example]:' => 'Foo',
    'Plugin ID [example_foo]:' => 'example_foo',
    'Plugin class [FooResource]:' => 'FooResource',
  ];

  protected array $fixtures = [
    'src/Plugin/rest/resource/FooResource.php' => '/_rest_resource.php',
  ];

}
