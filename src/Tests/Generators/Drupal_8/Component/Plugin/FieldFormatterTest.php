<?php

namespace DrupalCodeGenerator\Tests\Drupal_8\Component\Plugin;

use DrupalCodeGenerator\Tests\GeneratorTestCase;

/**
 * Test for d8:component:plugin:field-formatter command.
 */
class FieldFormatter extends GeneratorTestCase {

  /**
   * {@inheritdoc}
   */
  public function setUp() {
    $this->class = 'Drupal_8\Component\Plugin\FieldFormatter';
    $this->answers = [
      'Foo',
      'foo',
      'Zoo',
      'foo_zoo',
    ];
    $this->target = 'ZooFormatter.php';
    $this->fixture = __DIR__ . '/_field-formatter_' . $this->target;

    parent::setUp();
  }

}
