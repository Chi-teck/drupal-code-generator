<?php

namespace DrupalCodeGenerator\Tests\Generator\Drupal_8;

use DrupalCodeGenerator\Tests\Generator\GeneratorBaseTest;

/**
 * Test for d8:javascript command.
 */
class JavascriptTest extends GeneratorBaseTest {

  protected $class = 'Drupal_8\Javascript';

  protected $interaction = [
    'Module name [%default_name%]:' => 'Foo bar',
    'Module machine name [foo_bar]:' => 'foo_bar',
  ];

  protected $fixtures = [
    'js/foo-bar.js' => __DIR__ . '/_javascript.js',
  ];

}
