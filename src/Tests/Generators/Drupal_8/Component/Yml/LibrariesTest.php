<?php

namespace DrupalCodeGenerator\Tests\Drupal_8\Component\Yml;

use DrupalCodeGenerator\Tests\GeneratorTestCase;

/**
 * Test for d8:component:yml:libraries command.
 */
class LIbraries extends GeneratorTestCase {

  /**
   * {@inheritdoc}
   */
  public function setUp() {
    $this->class = 'Drupal_8\Component\Yml\Libraries';
    $this->answers = [
      'example',
    ];
    $this->target = 'example.libraries.yml';
    $this->fixture = __DIR__ . '/_' . $this->target;

    parent::setUp();
  }

}
