<?php

namespace DrupalCodeGenerator\Tests\Generator\Misc\Drupal_7;

use DrupalCodeGenerator\Tests\Generator\BaseGeneratorTest;

/**
 * Test for misc:d7:javascript-file command.
 */
class JavascriptTest extends BaseGeneratorTest {

  protected $class = 'Misc\Drupal_7\Javascript';

  protected $interaction = [
    'Module name [%default_name%]:' => 'Another example',
    'Module machine name [another_example]:' => 'another_example',
  ];

  protected $fixtures = [
    'another-example.js' => __DIR__ . '/_javascript.js',
  ];

}
