<?php

namespace DrupalCodeGenerator\Tests\Drupal_7\Component;

use DrupalCodeGenerator\Tests\GeneratorTestCase;

class InfoTest extends GeneratorTestCase {

  /**
   * {@inheritdoc}
   */
  public function setUp () {
    $this->class = 'Drupal_7\Component\Info';
    $this->answers = [
      'Example',
      'example',
      'Some description',
      'custom',
      '7.x-1.0',
    ];
    $this->target = 'example.info';
    $this->fixture = __DIR__ . '/_' . $this->target;

    parent::setUp();
  }

}
