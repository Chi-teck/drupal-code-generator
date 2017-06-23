<?php

namespace DrupalCodeGenerator\Tests\Generator\Drupal_8\Form;

use DrupalCodeGenerator\Tests\Generator\GeneratorBaseTest;

/**
 * Test for d8:form:simple command.
 */
class SimpleTest extends GeneratorBaseTest {

  protected $class = 'Drupal_8\Form\Simple';

  protected $interaction = [
    'Module name [%default_name%]: ' => 'Foo',
    'Module machine name [foo]: ' => 'foo',
    'Class [FooForm]: ' => 'ExampleForm',
    'Form ID [foo_example]: ' => 'foo_example',
  ];

  protected $fixtures = [
    'src/Form/ExampleForm.php' => __DIR__ . '/_simple.php',
  ];

}
