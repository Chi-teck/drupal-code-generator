<?php

namespace DrupalCodeGenerator\Tests\Drupal_8;

use DrupalCodeGenerator\Tests\GeneratorTestCase;

/**
 * Test for d8:controller command.
 */
class ControllerTest extends GeneratorTestCase {

  /**
   * {@inheritdoc}
   */
  public function setUp() {
    $this->class = 'Drupal_8\Controller';
    $this->answers = [
      'Example',
      'example',
      'ExampleController',
    ];
    $this->target = 'src/Controller/ExampleController.php';
    $this->fixture = __DIR__ . '/_controller.php';

    parent::setUp();
  }

}
