<?php

namespace DrupalCodeGenerator\Tests\Drupal_8\Component\Form;

use DrupalCodeGenerator\Tests\GeneratorTestCase;

/**
 * Test for d8:component:form:confirm command.
 */
class ConfirmTest extends GeneratorTestCase {

  /**
   * {@inheritdoc}
   */
  public function setUp() {
    $this->class = 'Drupal_8\Component\Form\Confirm';
    $this->answers = [
      'Foo',
      'foo',
      'ExampleConfirmForm',
      'foo_example_confirm',
    ];

    $this->target = 'ExampleConfirmForm.php';
    $this->fixture = __DIR__ . '/_confirm_' . $this->target;

    parent::setUp();
  }

}
