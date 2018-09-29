<?php

namespace DrupalCodeGenerator\Tests\Generator\Drupal_8;

use DrupalCodeGenerator\Tests\Generator\GeneratorBaseTest;

/**
 * Test for d8:controller command.
 */
class ControllerTest extends GeneratorBaseTest {

  protected $class = 'Drupal_8\Controller';

  protected $interaction = [
    'Module name [%default_name%]:' => 'Foo',
    'Module machine name [foo]:' => 'foo',
    'Class [FooController]:' => 'FooController',
    'Would you like to inject dependencies? [No]:' => 'Yes',
    '<1> Type the service name or use arrows up/down. Press enter to continue:' => 'database',
    '<2> Type the service name or use arrows up/down. Press enter to continue:' => '',
    'Would you like to create a route for this controller? [Yes]:' => 'Yes',
    'Route name [foo.example]:' => 'example.bar',
    'Route path [/foo/example]:' => '/foo/example',
    'Route title [Example]:' => 'Bar',
    'Route permission [access content]:' => 'access content',
  ];

  protected $fixtures = [
    'foo.routing.yml' => __DIR__ . '/_controller_routing.yml',
    'src/Controller/FooController.php' => __DIR__ . '/_controller.php',
  ];

}
