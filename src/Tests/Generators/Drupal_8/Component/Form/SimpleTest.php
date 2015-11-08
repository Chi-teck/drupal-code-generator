<?php

namespace DrupalCodeGenerator\Tests\Drupal_8\Component\Form;

use DrupalCodeGenerator\Tests\GeneratorTestCase;

/**
 * Test for d8:component:form:simple command.
 */
class SimpeTest extends GeneratorTestCase {

  /**
   * {@inheritdoc}
   */
  public function setUp() {
    $this->class = 'Drupal_8\Component\Form\Simple';
    $this->answers = [
      'Example',
      'example',
      'ExampleForm',
    ];

    $this->target = 'ExampleForm.php';
    $this->fixture = __DIR__ . '/_simple_' . $this->target;

    parent::setUp();
  }

}
