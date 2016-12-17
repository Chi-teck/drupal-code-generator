<?php

namespace DrupalCodeGenerator\Tests\Drupal_8\Form;

use DrupalCodeGenerator\Tests\GeneratorTestCase;

/**
 * Test for d8:form:confirm command.
 */
class ConfirmTest extends GeneratorTestCase {

  protected $class = 'Drupal_8\Form\Confirm';

  protected $answers = [
    'Foo',
    'foo',
    'ExampleConfirmForm',
    'foo_example_confirm',
  ];

  protected $fixtures = [
    'src/Form/ExampleConfirmForm.php' => __DIR__ . '/_confirm.php',
  ];

}
