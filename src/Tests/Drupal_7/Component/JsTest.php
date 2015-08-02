<?php

namespace DrupalCodeGenerator\Tests\Drupal_7\Component;

use DrupalCodeGenerator\Tests\GeneratorTestCase;

class JsTest extends GeneratorTestCase {

  /**
   * {@inheritdoc}
   */
  public function setUp () {
    $this->class = 'Drupal_7\Component\Js';
    $this->answers = [
      'Example',
      'example',
    ];

    $this->target = 'example.js';
    $this->fixture = __DIR__ . '/_' . $this->target;

    parent::setUp();
  }

}
