<?php

namespace DrupalCodeGenerator\Tests\Drupal_7\Component;

use DrupalCodeGenerator\Tests\GeneratorTestCase;

/**
 * Test for d7:component:theme-info-file command.
 */
class ThemeInfoTest extends GeneratorTestCase {

  /**
   * {@inheritdoc}
   */
  public function setUp() {
    $this->class = 'Drupal_7\Component\ThemeInfo';
    $this->answers = [
      'Bar',
      'bar',
      'Theme description',
      'omega',
      '7.x-1.0',
    ];
    $this->target = 'bar.info';
    $this->fixture = __DIR__ . '/_' . $this->target;

    parent::setUp();
  }

}
