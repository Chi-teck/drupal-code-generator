<?php

namespace DrupalCodeGenerator\Tests\Drupal_8;

use DrupalCodeGenerator\Tests\GeneratorTestCase;

/**
 * Test for d8:install command.
 */
class InstallTest extends GeneratorTestCase {

  /**
   * {@inheritdoc}
   */
  public function setUp() {
    $this->class = 'Drupal_8\Install';
    $this->answers = [
      'Foo',
      'foo',
    ];
    $this->target = 'foo.install';
    $this->fixture = __DIR__ . '/_.install';

    parent::setUp();
  }

}
