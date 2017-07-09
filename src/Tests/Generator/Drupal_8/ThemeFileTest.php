<?php

namespace DrupalCodeGenerator\Tests\Generator\Drupal_8;

use DrupalCodeGenerator\Tests\Generator\GeneratorBaseTest;

/**
 * Test for d8:theme-file command.
 */
class ThemeFileTest extends GeneratorBaseTest {

  protected $class = 'Drupal_8\ThemeFile';

  protected $interaction = [
    'Theme name [%default_name%]: ' => 'Foo',
    'Theme machine name [foo]: ' => 'foo',
  ];

  protected $fixtures = [
    'foo.theme' => __DIR__ . '/_.theme',
  ];

}
