<?php

namespace DrupalCodeGenerator\Tests\Drupal_6\Component;

use DrupalCodeGenerator\Tests\GeneratorTestCase;

class InfoTest extends GeneratorTestCase {

  /**
   * {@inheritdoc}
   */
  public function setUp () {
    $this->class = 'Drupal_6\Component\Info';
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
