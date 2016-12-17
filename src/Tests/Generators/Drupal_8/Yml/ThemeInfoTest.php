<?php

namespace DrupalCodeGenerator\Tests\Drupal_8\Yml;

use DrupalCodeGenerator\Tests\GeneratorTestCase;

/**
 * Test for d8:yml:theme-info command.
 */
class ThemeInfoTest extends GeneratorTestCase {

  protected $class = 'Drupal_8\Yml\ThemeInfo';

  protected $answers = [
    'Example',
    'example',
    'garland',
    'Example description.',
    'custom',
    '8.x-1.0-dev',
  ];

  protected $fixtures = [
    'example.info.yml' => __DIR__ . '/_theme_info.yml',
  ];

}
