<?php

namespace DrupalCodeGenerator\Tests\Drupal_7;

use DrupalCodeGenerator\Tests\GeneratorTestCase;

/**
 * Test for d7:module-file command.
 */
class ModuleTest extends GeneratorTestCase {

  /**
   * {@inheritdoc}
   */
  public function setUp() {
    $this->class = 'Drupal_7\ModuleFile';
    $this->answers = [
      'Example',
      'example',
    ];
    $this->target = 'example.module';
    $this->fixture = __DIR__ . '/_' . $this->target;
    parent::setUp();
  }

}
