<?php

namespace DrupalCodeGenerator\Tests\Generator\Drupal_7;

use DrupalCodeGenerator\Tests\Generator\GeneratorTestCase;

/**
 * Test for d7:theme-info-file command.
 */
class ThemeInfoTest extends GeneratorTestCase {

  protected $class = 'Drupal_7\ThemeInfo';

  protected $answers = [
    'Bar',
    'bar',
    'Theme description',
    'omega',
    '7.x-1.0',
  ];

  protected $fixtures = [
    'bar.info' => __DIR__ . '/_theme.info',
  ];

}
