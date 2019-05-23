<?php

namespace DrupalCodeGenerator\Tests\Generator\Drupal_8;

use DrupalCodeGenerator\Tests\Generator\BaseGeneratorTest;

/**
 * Test for theme-file command.
 */
class ThemeFileGeneratorTest extends BaseGeneratorTest {

  protected $class = 'ThemeFile';

  protected $interaction = [
    'Theme name [%default_name%]:' => 'Foo',
    'Theme machine name [foo]:' => 'foo',
  ];

  protected $fixtures = [
    'foo.theme' => __DIR__ . '/_.theme',
  ];

}
