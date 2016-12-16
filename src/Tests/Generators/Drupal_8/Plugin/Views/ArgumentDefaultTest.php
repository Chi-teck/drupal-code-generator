<?php

namespace DrupalCodeGenerator\Tests\Drupal_8\Plugin;

use DrupalCodeGenerator\Tests\GeneratorTestCase;

/**
 * Test for d8:plugin:views:argument-default command.
 */
class ViewsArgumentDefaultTest extends GeneratorTestCase {

  /**
   * {@inheritdoc}
   */
  public function setUp() {
    $this->class = 'Drupal_8\Plugin\Views\ArgumentDefault';
    $this->answers = [
      'Foo',
      'foo',
      'Example',
      'foo_example',
    ];
    $this->target = 'Example.php';
    $this->fixture = __DIR__ . '/_argument_default.php';

    parent::setUp();
  }

}
