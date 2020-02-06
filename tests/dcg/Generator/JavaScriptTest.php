<?php

namespace DrupalCodeGenerator\Tests\Generator;

/**
 * Test for javascript command.
 */
final class JavaScriptTest extends BaseGeneratorTest {

  protected $class = 'JavaScript';

  protected $interaction = [
    'Module name [%default_name%]:' => 'Foo bar',
    'Module machine name [foo_bar]:' => 'foo_bar',
  ];

  protected $fixtures = [
    'js/foo-bar.js' => '/_javascript.js',
  ];

}
