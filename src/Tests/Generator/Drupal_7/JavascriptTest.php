<?php

namespace DrupalCodeGenerator\Tests\Generator\Drupal_7;

use DrupalCodeGenerator\Tests\Generator\GeneratorTestCase;

/**
 * Test for d7:javascript-file command.
 */
class JavascriptTest extends GeneratorTestCase {

  protected $class = 'Drupal_7\Javascript';

  protected $answers = [
    'Another example',
    'another_example',
  ];

  protected $fixtures = [
    'another-example.js' => __DIR__ . '/_javascript.js',
  ];

}
