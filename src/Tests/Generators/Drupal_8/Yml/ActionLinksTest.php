<?php

namespace DrupalCodeGenerator\Tests\Drupal_8\Yml;

use DrupalCodeGenerator\Tests\GeneratorTestCase;

/**
 * Test for d8:yml:action-links command.
 */
class ActionLinksTest extends GeneratorTestCase {

  /**
   * {@inheritdoc}
   */
  public function setUp() {
    $this->class = 'Drupal_8\Yml\ActionLinks';
    $this->answers = ['example'];
    $this->target = 'example.links.action.yml';
    $this->fixture = __DIR__ . '/_links.action.yml';

    parent::setUp();
  }

}
