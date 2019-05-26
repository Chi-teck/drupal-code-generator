<?php

namespace DrupalCodeGenerator\Tests\Generator\Form;

use DrupalCodeGenerator\Tests\Generator\BaseGeneratorTest;

/**
 * Test for form:confirm command.
 */
class ConfirmTest extends BaseGeneratorTest {

  protected $class = 'Form\Confirm';

  protected $interaction = [
    'Module name [%default_name%]:' => 'Foo',
    'Module machine name [foo]:' => 'foo',
    'Class [ExampleConfirmForm]:' => 'ExampleConfirmForm',
    'Would you like to create a route for this form? [Yes]:' => 'Yes',
    'Route name [foo.example_confirm]:' => 'foo.example',
    'Route path [/foo/example-confirm]:' => '/foo/example',
    'Route title [Example confirm]:' => 'Wow',
    'Route permission [administer site configuration]:' => 'administer site configuration',
  ];

  protected $fixtures = [
    'foo.routing.yml' => __DIR__ . '/_confirm_routing.yml',
    'src/Form/ExampleConfirmForm.php' => __DIR__ . '/_confirm.php',
  ];

}
