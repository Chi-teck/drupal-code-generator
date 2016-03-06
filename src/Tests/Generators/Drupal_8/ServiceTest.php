<?php

namespace DrupalCodeGenerator\Tests\Drupal_8;

use DrupalCodeGenerator\Tests\GeneratorTestCase;

/**
 * Test for d8:service command.
 */
class ServiceTest extends GeneratorTestCase {

  /**
   * {@inheritdoc}
   */
  public function setUp() {
    $this->class = 'Drupal_8\Service';
    $this->answers = [
      'Foo',
      'foo',
      'foo.example',
      'Example',
    ];
    $this->target = 'Example.php';
    $this->fixture = __DIR__ . '/_service.php';

    parent::setUp();
  }

}
