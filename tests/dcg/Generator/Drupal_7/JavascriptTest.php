<?php

namespace DrupalCodeGenerator\Tests\Generator\Drupal_7;

use DrupalCodeGenerator\Tests\Generator\GeneratorBaseTest;

/**
 * Test for d7:javascript-file command.
 */
class JavascriptTest extends GeneratorBaseTest {

  protected $class = 'Drupal_7\Javascript';

  protected $interaction = [
    'Module name [%default_name%]:' => 'Another example',
    'Module machine name [another_example]:' => 'another_example',
  ];

  protected $fixtures = [
    'another-example.js' => __DIR__ . '/_javascript.js',
  ];

}
