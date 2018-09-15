<?php

namespace DrupalCodeGenerator\Tests\Generator\Drupal_8\Form;

use DrupalCodeGenerator\Tests\Generator\GeneratorBaseTest;

/**
 * Test for d8:form:simple command.
 */
class SimpleTest extends GeneratorBaseTest {

  protected $class = 'Drupal_8\Form\Simple';

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
    'foo.routing.yml' => __DIR__ . '/_simple_routing.yml',
    'src/Form/ExampleForm.php' => __DIR__ . '/_simple.php',
  ];

}
