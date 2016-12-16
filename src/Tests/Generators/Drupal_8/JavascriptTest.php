<?php

namespace DrupalCodeGenerator\Tests\Drupal_8;

use DrupalCodeGenerator\Tests\GeneratorTestCase;

/**
 * Test for d8:javascript command.
 */
class JavascriptTest extends GeneratorTestCase {

  /**
   * {@inheritdoc}
   */
  public function setUp() {
    $this->class = 'Drupal_8\Javascript';
    $this->answers = [
      'Foo',
      'foo',
    ];
    $this->target = 'js/foo.js';
    $this->fixture = __DIR__ . '/_javascript.js';
    parent::setUp();
  }

}
