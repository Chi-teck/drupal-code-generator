<?php

namespace DrupalCodeGenerator\Tests\Generator;

/**
 * Test for controller command.
 */
final class ControllerTest extends BaseGeneratorTest {

  protected $class = 'Controller';

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
    'foo.routing.yml' => '/_controller_routing.yml',
    'src/Controller/FooController.php' => '/_controller.php',
  ];

}
