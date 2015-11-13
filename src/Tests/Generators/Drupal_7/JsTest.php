<?php

namespace DrupalCodeGenerator\Tests\Drupal_7;

use DrupalCodeGenerator\Tests\GeneratorTestCase;

/**
 * Test for d7:js-file command.
 */
class JsTest extends GeneratorTestCase {

  /**
   * {@inheritdoc}
   */
  public function setUp() {
    $this->class = 'Drupal_7\Js';
    $this->answers = [
      'Example',
      'example',
    ];

    $this->target = 'example.js';
    $this->fixture = __DIR__ . '/_' . $this->target;

    parent::setUp();
  }

}
