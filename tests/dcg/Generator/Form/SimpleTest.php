<?php

namespace DrupalCodeGenerator\Tests\Generator\Form;

use DrupalCodeGenerator\Tests\Generator\BaseGeneratorTest;

/**
 * Test for form:simple command.
 */
class SimpleTest extends BaseGeneratorTest {

  protected $class = 'Form\Simple';

  protected $interaction = [
    'Module name [%default_name%]:' => 'Foo',
    'Module machine name [foo]:' => 'foo',
    'Class [ExampleForm]:' => 'ExampleForm',
    'Would you like to create a route for this form? [Yes]:' => 'Yes',
    'Route name [foo.example]:' => 'foo.example',
    'Route path [/foo/example]:' => '/foo/example',
    'Route title [Example]:' => 'Hey',
    'Route permission [access content]:' => 'access content',
  ];

  protected $fixtures = [
    'foo.routing.yml' => '/_simple_routing.yml',
    'src/Form/ExampleForm.php' => '/_simple.php',
  ];

}
