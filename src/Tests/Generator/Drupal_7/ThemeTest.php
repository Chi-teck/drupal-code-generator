<?php

namespace DrupalCodeGenerator\Tests\Generator\Drupal_7;

use DrupalCodeGenerator\Tests\Generator\GeneratorBaseTest;

/**
 * Test for d7:theme command.
 */
class ThemeTest extends GeneratorBaseTest {

  protected $class = 'Drupal_7\Theme';

  protected $interaction = [
    'Theme name [%default_name%]: ' => 'Example',
    'Theme machine name [example]: ' => 'example',
    'Theme description [A simple Drupal 7 theme.]: ' => 'example',
    'Base theme: ' => 'example',
    'Version [7.x-1.0-dev]: ' => 'example',
  ];

  protected $fixtures = [
    'example/example.info' => NULL,
    'example/images' => NULL,
    'example/template.php' => NULL,
    'example/templates' => NULL,
    'example/css/example.css' => NULL,
    'example/js/example.js' => NULL,
  ];

}
