<?php

namespace DrupalCodeGenerator\Tests\Generator\Drupal_8\Form;

use DrupalCodeGenerator\Tests\Generator\GeneratorBaseTest;

/**
 * Test for d8:form:confirm command.
 */
class ConfirmTest extends GeneratorBaseTest {

  protected $class = 'Drupal_8\Form\Confirm';

  protected $interaction = [
    'Module name [%default_name%]:' => 'Foo',
    'Module machine name [foo]:' => 'foo',
    'Class [ExampleConfirmForm]:' => 'ExampleConfirmForm',
    'Form ID [foo_example_confirm]:' => 'foo_example_confirm',
    'Would you like to create a route for this form? [Yes]:' => 'Yes',
    'Route name [foo.example]:' => 'foo.example',
    'Route path [/foo/example]:' => '/foo/example',
    'Route title [Example]:' => 'Wow',
    'Route permission [administer site configuration]:' => 'administer site configuration',
  ];

  protected $fixtures = [
    'foo.routing.yml' => __DIR__ . '/_confirm_routing.yml',
    'src/Form/ExampleConfirmForm.php' => __DIR__ . '/_confirm.php',
  ];

}
