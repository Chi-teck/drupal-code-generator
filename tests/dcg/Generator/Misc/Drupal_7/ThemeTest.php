<?php

namespace DrupalCodeGenerator\Tests\Generator\Misc\Drupal_7;

use DrupalCodeGenerator\Tests\Generator\BaseGeneratorTest;

/**
 * Test for misc:d7:theme command.
 */
class ThemeTest extends BaseGeneratorTest {

  protected $class = 'Misc\Drupal_7\Theme';

  protected $interaction = [
    'Theme name [%default_name%]:' => 'Example',
    'Theme machine name [example]:' => 'example',
    'Theme description [A simple Drupal 7 theme.]:' => 'A theme for test.',
    'Base theme:' => 'garland',
  ];

  protected $fixtures = [
    'example/example.info' => __DIR__ . '/_theme/example.info',
    'example/images' => [],
    'example/template.php' => __DIR__ . '/_theme/template.php',
    'example/templates' => [],
    'example/css/example.css' => __DIR__ . '/_theme/css/example.css',
    'example/js/example.js' => __DIR__ . '/_theme/js/example.js',
  ];

}
