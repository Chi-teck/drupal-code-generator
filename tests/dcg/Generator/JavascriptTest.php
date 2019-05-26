<?php

namespace DrupalCodeGenerator\Tests\Generator;

/**
 * Test for javascript command.
 */
class JavascriptTest extends BaseGeneratorTest {

  protected $class = 'Javascript';

  protected $interaction = [
    'Module name [%default_name%]:' => 'Foo bar',
    'Module machine name [foo_bar]:' => 'foo_bar',
  ];

  protected $fixtures = [
    'js/foo-bar.js' => __DIR__ . '/_javascript.js',
  ];

}
