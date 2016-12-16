<?php

namespace DrupalCodeGenerator\Tests\Drupal_8\Form;

use DrupalCodeGenerator\Tests\GeneratorTestCase;

/**
 * Test for d8:form:confirm command.
 */
class ConfirmTest extends GeneratorTestCase {

  /**
   * {@inheritdoc}
   */
  public function setUp() {
    $this->class = 'Drupal_8\Form\Confirm';
    $this->answers = [
      'Foo',
      'foo',
      'ExampleConfirmForm',
      'foo_example_confirm',
    ];

    $this->target = 'src/Form/ExampleConfirmForm.php';
    $this->fixture = __DIR__ . '/_confirm.php';

    parent::setUp();
  }

}
