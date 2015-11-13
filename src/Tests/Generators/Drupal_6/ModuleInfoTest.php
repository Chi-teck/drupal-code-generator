<?php

namespace DrupalCodeGenerator\Tests\Drupal_6;

use DrupalCodeGenerator\Tests\GeneratorTestCase;

/**
 * Test for d6:module-info-file command.
 */
class ModuleInfoTest extends GeneratorTestCase {

  /**
   * {@inheritdoc}
   */
  public function setUp() {
    $this->class = 'Drupal_6\ModuleInfo';
    $this->answers = [
      'Example',
      'example',
      'Some description',
      'custom',
      '6.x-1.0',
    ];
    $this->target = 'example.info';
    $this->fixture = __DIR__ . '/_' . $this->target;

    parent::setUp();
  }

}
