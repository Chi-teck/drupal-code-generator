<?php declare(strict_types=1);

namespace DrupalCodeGenerator\Tests\Functional\Generator\Form;

use DrupalCodeGenerator\Command\Form\Simple;
use DrupalCodeGenerator\Test\Functional\GeneratorTestBase;

/**
 * Tests form:simple generator.
 */
final class SimpleTest extends GeneratorTestBase {

  protected string $fixtureDir = __DIR__ . '/_simple';

  public function testGenerator(): void {
    $input = [
      'foo',
      'ExampleForm',
      'Yes',
      'foo.example',
      '/foo/example',
      'Hey',
      'access content',
    ];
    $this->execute(new Simple(), $input);

    $expected_display = <<< 'TXT'

     Welcome to form generator!
    ––––––––––––––––––––––––––––

     Module machine name [%default_name%]:
     ➤ 

     Class [ExampleForm]:
     ➤ 

     Would you like to create a route for this form? [Yes]:
     ➤ 

     Route name [foo.example]:
     ➤ 

     Route path [/foo/example]:
     ➤ 

     Route title [Example]:
     ➤ 

     Route permission [access content]:
     ➤ 

     The following directories and files have been created or updated:
    –––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––
     • foo.routing.yml
     • src/Form/ExampleForm.php

    TXT;
    $this->assertDisplay($expected_display);

    $this->assertGeneratedFile('foo.routing.yml');
    $this->assertGeneratedFile('src/Form/ExampleForm.php');
  }

}
