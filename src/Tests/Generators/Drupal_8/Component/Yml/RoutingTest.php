<?php

namespace DrupalCodeGenerator\Tests\Drupal_8\Component\Yml;

use DrupalCodeGenerator\Tests\GeneratorTestCase;

/**
 * Test for d8:component:yml:routing command.
 */
class Routing extends GeneratorTestCase {

  /**
   * {@inheritdoc}
   */
  public function setUp() {
    $this->class = 'Drupal_8\Component\Yml\Routing';
    $this->answers = [
      'Example',
      'example',
    ];

    $this->target = 'example.routing.yml';
    $this->fixture = __DIR__ . '/_' . $this->target;

    parent::setUp();
  }

}
