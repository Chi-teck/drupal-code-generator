<?php

namespace DrupalCodeGenerator\Tests\Generator\Drupal_7;

use DrupalCodeGenerator\Tests\Generator\GeneratorBaseTest;

/**
 * Test for d7:theme-info-file command.
 */
class ThemeInfoTest extends GeneratorBaseTest {

  protected $class = 'Drupal_7\ThemeInfo';

  protected $interaction = [
    'Theme name [%default_name%]:' => 'Bar',
    'Theme machine name [bar]:' => 'bar',
    'Theme description [A simple Drupal 7 theme.]:' => 'Theme description',
    'Base theme:' => 'omega',
  ];

  protected $fixtures = [
    'bar.info' => __DIR__ . '/_theme.info',
  ];

}
