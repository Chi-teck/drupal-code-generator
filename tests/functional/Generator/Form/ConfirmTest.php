<?php declare(strict_types = 1);

namespace DrupalCodeGenerator\Tests\Functional\Generator\Form;

use DrupalCodeGenerator\Command\Form\Confirm;
use DrupalCodeGenerator\Test\Functional\GeneratorTestBase;

/**
 * Tests form:confirm generator.
 */
final class ConfirmTest extends GeneratorTestBase {

  protected string $fixtureDir = __DIR__ . '/_confirm';

  public function testGenerator(): void {
    $input = [
      'foo',
      'ExampleConfirmForm',
      'Yes',
      'foo.example',
      '/foo/example',
      'Wow',
      'administer site configuration',
    ];
    $this->execute(Confirm::class, $input);

    $expected_display = <<< 'TXT'

     Welcome to confirm-form generator!
    ––––––––––––––––––––––––––––––––––––

     Module machine name:
     ➤ 

     Class [ExampleConfirmForm]:
     ➤ 

     Would you like to create a route for this form? [Yes]:
     ➤ 

     Route name [foo.example_confirm]:
     ➤ 

     Route path [/foo/example-confirm]:
     ➤ 

     Route title [Example confirm]:
     ➤ 

     Route permission [administer site configuration]:
     ➤ 

     The following directories and files have been created or updated:
    –––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––
     • foo.routing.yml
     • src/Form/ExampleConfirmForm.php

    TXT;
    $this->assertDisplay($expected_display);

    $this->assertGeneratedFile('foo.routing.yml');
    $this->assertGeneratedFile('src/Form/ExampleConfirmForm.php');
  }

}
