<?php

namespace DrupalCodeGenerator\Tests\Drupal_8\Yml;

use DrupalCodeGenerator\Tests\GeneratorTestCase;

/**
 * Test for d8:yml:routing command.
 */
class RoutingTest extends GeneratorTestCase {

  /**
   * {@inheritdoc}
   */
  public function setUp() {
    $this->class = 'Drupal_8\Yml\Routing';
    $this->answers = [
      'Example',
      'example',
    ];

    $this->target = 'example.routing.yml';
    $this->fixture = __DIR__ . '/_routing.yml';

    parent::setUp();
  }

}
