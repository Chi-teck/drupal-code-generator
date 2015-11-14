<?php

namespace DrupalCodeGenerator\Tests\Drupal_7;

use DrupalCodeGenerator\Tests\GeneratorTestCase;

/**
 * Test for d7:javascript-file command.
 */
class JavascriptTest extends GeneratorTestCase {

  /**
   * {@inheritdoc}
   */
  public function setUp() {
    $this->class = 'Drupal_7\Javascript';
    $this->answers = [
      'Example',
      'example',
    ];

    $this->target = 'example.js';
    $this->fixture = __DIR__ . '/_javascript.js';

    parent::setUp();
  }

}
