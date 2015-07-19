<?php

namespace DrupalCodeGenerator\Tests\Drupal_7\Component;

use DrupalCodeGenerator\Commands\Drupal_7\Component\Js;
use DrupalCodeGenerator\Tests\GeneratorTestCase;

class JsTest extends GeneratorTestCase {

  /**
   * {@inheritdoc}
   */
  public function setUp () {
    $this->command = new Js();
    $this->commandName = 'generate:d7:component:js-file';
    $this->answers = [
      'Example',
      'example',
    ];

    $this->target = 'example.js';
    $this->fixture = __DIR__ . '/_' . $this->target;

    parent::setUp();
  }

}
