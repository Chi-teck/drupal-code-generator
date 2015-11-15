<?php

namespace DrupalCodeGenerator\Tests\Drupal_8\Plugin;

use DrupalCodeGenerator\Tests\GeneratorTestCase;

/**
 * Test for d8:plugin:block command.
 */
class BlockTest extends GeneratorTestCase {

  /**
   * {@inheritdoc}
   */
  public function setUp() {
    $this->class = 'Drupal_8\Plugin\Block';
    $this->answers = [
      'Foo',
      'foo',
      'Example',
      'foo_example',
      'Custom',
    ];
    $this->target = 'ExampleBlock.php';
    $this->fixture = __DIR__ . '/_block.php';

    parent::setUp();
  }

}
