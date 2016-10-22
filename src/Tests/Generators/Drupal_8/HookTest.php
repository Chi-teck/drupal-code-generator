<?php

namespace DrupalCodeGenerator\Tests\Drupal_8;

use DrupalCodeGenerator\Tests\GeneratorTestCase;

/**
 * Test for d8:hook command.
 */
class HookTest extends GeneratorTestCase {

  /**
   * {@inheritdoc}
   */
  public function setUp() {
    $this->class = 'Drupal_8\Hook';
    $this->answers = [
      'Example',
      'example',
      'theme',
    ];
    $this->target = 'example.module';
    $this->fixture = __DIR__ . '/_hook.module';
    parent::setUp();
  }

}
