<?php

namespace DrupalCodeGenerator\Tests\Drupal_7\Component;

use DrupalCodeGenerator\Tests\GeneratorTestCase;

class InstallTest extends GeneratorTestCase {

  /**
   * {@inheritdoc}
   */
  public function setUp () {
    $this->class = 'Drupal_7\Component\Install';
    $this->answers = [
      'Example',
      'example',
    ];
    $this->target = 'example.install';
    $this->fixture = __DIR__ . '/_' . $this->target;
    parent::setUp();
  }

}
