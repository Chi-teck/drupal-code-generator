<?php

namespace DrupalCodeGenerator\Tests\Drupal_8\Test;

use DrupalCodeGenerator\Tests\GeneratorTestCase;

/**
 * Test for d8:test:javascript command.
 */
class JavascriptTest extends GeneratorTestCase {

  protected $class = 'Drupal_8\Test\Javascript';

  protected $answers = [
    'Foo',
    'foo',
    'Example',
  ];

  protected $fixtures = [
    'tests/src/FunctionalJavascript/ExampleTest.php' => __DIR__ . '/_javascript.php',
  ];

}
