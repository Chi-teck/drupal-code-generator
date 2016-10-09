<?php

namespace DrupalCodeGenerator\Tests\Drupal_8\Plugin;

use DrupalCodeGenerator\Tests\GeneratorTestCase;

/**
 * Test for d8:plugin:action command.
 */
class ActionTest extends GeneratorTestCase {

  /**
   * {@inheritdoc}
   */
  public function setUp() {
    $this->class = 'Drupal_8\Plugin\Action';
    $this->answers = [
      'Example',
      'example',
      'Foo',
      'example_foo',
      'Custom',
      'yes',
    ];
    $this->target = 'Foo.php';
    $this->fixture = __DIR__ . '/_action.php';

    parent::setUp();
  }

}
