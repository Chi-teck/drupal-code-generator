<?php

namespace DrupalCodeGenerator\Tests\Drupal_8\Plugin;

use DrupalCodeGenerator\Tests\GeneratorTestCase;

/**
 * Test for d8:plugin:condition command.
 */
class Condtion extends GeneratorTestCase {

  /**
   * {@inheritdoc}
   */
  public function setUp() {
    $this->class = 'Drupal_8\Plugin\Condition';
    $this->answers = [
      'Foo',
      'foo',
      'Example',
      'foo_example',
    ];
    $this->target = 'Example.php';
    $this->fixture = __DIR__ . '/_condition.php';

    parent::setUp();
  }

}
