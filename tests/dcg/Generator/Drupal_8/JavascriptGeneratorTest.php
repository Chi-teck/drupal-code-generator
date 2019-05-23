<?php

namespace DrupalCodeGenerator\Tests\Generator\Drupal_8;

use DrupalCodeGenerator\Tests\Generator\BaseGeneratorTest;

/**
 * Test for javascript command.
 */
class JavascriptGeneratorTest extends BaseGeneratorTest {

  protected $class = 'Javascript';

  protected $interaction = [
    'Module name [%default_name%]:' => 'Foo bar',
    'Module machine name [foo_bar]:' => 'foo_bar',
  ];

  protected $fixtures = [
    'js/foo-bar.js' => __DIR__ . '/_javascript.js',
  ];

}
