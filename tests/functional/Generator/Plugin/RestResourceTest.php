<?php declare(strict_types = 1);

namespace DrupalCodeGenerator\Tests\Functional\Generator\Plugin;

use DrupalCodeGenerator\Command\Plugin\RestResource;
use DrupalCodeGenerator\Test\Functional\GeneratorTestBase;

/**
 * Tests plugin:rest-resource generator.
 */
final class RestResourceTest extends GeneratorTestBase {

  protected string $fixtureDir = __DIR__ . '/_rest_resource';

  /**
   * Test callback.
   */
  public function testGenerator(): void {
    $input = [
      'example',
      'Foo',
      'example_foo',
      'FooResource',
    ];
    $this->execute(RestResource::class, $input);

    $expected_display = <<< 'TXT'

     Welcome to rest-resource generator!
    –––––––––––––––––––––––––––––––––––––

     Module machine name:
     ➤ 

     Plugin label:
     ➤ 

     Plugin ID [example_foo]:
     ➤ 

     Plugin class [FooResource]:
     ➤ 

     The following directories and files have been created or updated:
    –––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––
     • src/Plugin/rest/resource/FooResource.php

    TXT;
    $this->assertDisplay($expected_display);

    $this->assertGeneratedFile('src/Plugin/rest/resource/FooResource.php');
  }

}
