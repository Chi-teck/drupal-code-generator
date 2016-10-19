<?php

namespace DrupalCodeGenerator\Tests\Drupal_7;

use DrupalCodeGenerator\Tests\GeneratorTestCase;

/**
 * Test for d7:hook command.
 */
class HookTest extends GeneratorTestCase {

  /**
   * {@inheritdoc}
   */
  public function setUp() {
    $this->class = 'Drupal_7\Hook';
    $this->answers = [
      'Example',
      'example',
      'init',
    ];
    $this->target = 'example.module';
    $this->fixture = __DIR__ . '/_hook.module';
    parent::setUp();
  }

}
