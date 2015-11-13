<?php

namespace DrupalCodeGenerator\Tests\Drupal_8\Yml;

use DrupalCodeGenerator\Tests\GeneratorTestCase;

/**
 * Test for d8:yml:module-info command.
 */
class ModuleInfoTest extends GeneratorTestCase {

  /**
   * {@inheritdoc}
   */
  public function setUp() {
    $this->class = 'Drupal_8\Yml\ModuleInfo';
    $this->answers = [
      'Example',
      'example',
      'Example description.',
      'custom',
      '8.x-1.0-dev',
      'example.settings',
      'views, node, fields',
    ];
    $this->target = 'example.info.yml';
    $this->fixture = __DIR__ . '/_module_' . $this->target;

    parent::setUp();
  }

}
