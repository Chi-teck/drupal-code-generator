<?php

namespace DrupalCodeGenerator\Tests\Drupal_8\Yml;

use DrupalCodeGenerator\Tests\GeneratorTestCase;

/**
 * Test for d8:yml:theme-info command.
 */
class ThemeInfoTest extends GeneratorTestCase {

  /**
   * {@inheritdoc}
   */
  public function setUp() {
    $this->class = 'Drupal_8\Yml\ThemeInfo';
    $this->answers = [
      'Example',
      'example',
      'garland',
      'Example description.',
      'custom',
      '8.x-1.0-dev',
    ];
    $this->target = 'example.info.yml';
    $this->fixture = __DIR__ . '/_theme_info.yml';

    parent::setUp();
  }

}
