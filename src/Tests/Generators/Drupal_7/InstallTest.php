<?php

namespace DrupalCodeGenerator\Tests\Drupal_7;

use DrupalCodeGenerator\Tests\GeneratorTestCase;

/**
 * Test for d7:install-file command.
 */
class InstallTest extends GeneratorTestCase {

  /**
   * {@inheritdoc}
   */
  public function setUp() {
    $this->class = 'Drupal_7\Install';
    $this->answers = [
      'Example',
      'example',
    ];
    $this->target = 'example.install';
    $this->fixture = __DIR__ . '/_' . $this->target;
    parent::setUp();
  }

}
