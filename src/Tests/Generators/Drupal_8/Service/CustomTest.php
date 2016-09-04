<?php

namespace DrupalCodeGenerator\Tests\Drupal_8\Service;

use DrupalCodeGenerator\Tests\GeneratorTestCase;

/**
 * Test for d8:service:custom command.
 */
class CustomTest extends GeneratorTestCase {

  /**
   * {@inheritdoc}
   */
  public function setUp() {
    $this->class = 'Drupal_8\Service\Custom';
    $this->answers = [
      'Foo',
      'foo',
      'foo.example',
      'Example',
    ];
    $this->target = 'Example.php';
    $this->fixture = __DIR__ . '/_custom.php';

    parent::setUp();
  }

}
