<?php

namespace DrupalCodeGenerator\Tests\Drupal_8\Yml;

use DrupalCodeGenerator\Tests\GeneratorTestCase;

/**
 * Test for d8:yml:services command.
 */
class ServicesTest extends GeneratorTestCase {

  /**
   * {@inheritdoc}
   */
  public function setUp() {
    $this->class = 'Drupal_8\Yml\Services';
    $this->answers = [
      'Foo',
      'foo',
    ];
    $this->target = 'foo.services.yml';
    $this->fixture = __DIR__ . '/_services.yml';

    parent::setUp();
  }

}
