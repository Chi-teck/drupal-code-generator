<?php

namespace DrupalCodeGenerator\Tests\Generator\Drupal_8\Form;

use DrupalCodeGenerator\Tests\Generator\GeneratorBaseTest;

/**
 * Test for d8:form:confirm command.
 */
class ConfirmTest extends GeneratorBaseTest {

  protected $class = 'Drupal_8\Form\Confirm';

  protected $interaction = [
    'Module name [%default_name%]: ' => 'Foo',
    'Module machine name [foo]: ' => 'foo',
    'Class [ExampleConfirmForm]: ' => 'ExampleConfirmForm',
    'Form ID [foo_example_confirm]: ' => 'foo_example_confirm',
  ];

  protected $fixtures = [
    'src/Form/ExampleConfirmForm.php' => __DIR__ . '/_confirm.php',
  ];

}
