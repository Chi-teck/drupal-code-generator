<?php

namespace DrupalCodeGenerator\Tests\Generator;

/**
 * Test for theme-file command.
 */
class ThemeFileTest extends BaseGeneratorTest {

  protected $class = 'ThemeFile';

  protected $interaction = [
    'Theme name [%default_name%]:' => 'Foo',
    'Theme machine name [foo]:' => 'foo',
  ];

  protected $fixtures = [
    'foo.theme' => __DIR__ . '/_.theme',
  ];

}
