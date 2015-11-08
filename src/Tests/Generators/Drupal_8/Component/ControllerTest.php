<?php

namespace DrupalCodeGenerator\Tests\Drupal_8\Component;

use DrupalCodeGenerator\Tests\GeneratorTestCase;

/**
 * Test for d8:component:controller command.
 */
class ControllerTest extends GeneratorTestCase {

  /**
   * {@inheritdoc}
   */
  public function setUp() {
    $this->class = 'Drupal_8\Component\Controller';
    $this->answers = [
      'Example',
      'example',
      'ExampleController',
    ];
    $this->target = 'ExampleController.php';
    $this->fixture = __DIR__ . '/_controller_' . $this->target;

    parent::setUp();
  }

}
