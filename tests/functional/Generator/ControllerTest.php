<?php declare(strict_types = 1);

namespace DrupalCodeGenerator\Tests\Functional\Generator;

use DrupalCodeGenerator\Command\Controller;
use DrupalCodeGenerator\Test\Functional\GeneratorTestBase;

/**
 * Tests controller generator.
 *
 * @todo Test default values of route variables.
 */
final class ControllerTest extends GeneratorTestBase {

  protected string $fixtureDir = __DIR__ . '/_controller';

  /**
   * Test callback.
   */
  public function testGenerator(): void {
    $input = [
      'foo',
      'Foo',
      'FooController',
      'Yes',
      'database',
      '',
      'Yes',
      'example.bar',
      '/foo/example',
      'Bar',
      'access content',
    ];
    $this->execute(Controller::class, $input);

    $expected_display = <<< 'TXT'

     Welcome to controller generator!
    ––––––––––––––––––––––––––––––––––

     Module machine name:
     ➤ 

     Module name [Foo]:
     ➤ 

     Class [FooController]:
     ➤ 

     Would you like to inject dependencies? [No]:
     ➤ 

     Type the service name or use arrows up/down. Press enter to continue:
     ➤ 

     Type the service name or use arrows up/down. Press enter to continue:
     ➤ 

     Would you like to create a route for this controller? [Yes]:
     ➤ 

     Route name [foo.example]:
     ➤ 

     Route path [/foo/example-bar]:
     ➤ 

     Route title [Example Bar]:
     ➤ 

     Route permission [access content]:
     ➤ 

     The following directories and files have been created or updated:
    –––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––
     • foo.info.yml
     • foo.routing.yml
     • src/Controller/FooController.php

    TXT;
    $this->assertDisplay($expected_display);

    $this->assertGeneratedFile('src/Controller/FooController.php');
    $this->assertGeneratedFile('foo.routing.yml');
  }

}
