<?php

namespace DrupalCodeGenerator\Tests\Generator\Drupal_8\Test;

use DrupalCodeGenerator\Tests\Generator\BaseGeneratorTest;

/**
 * Test for d8:test:browser command.
 */
class BrowserGeneratorTest extends BaseGeneratorTest {

  protected $class = 'Drupal_8\Test\Browser';

  protected $interaction = [
    'Module name [%default_name%]:' => 'Foo',
    'Module machine name [foo]:' => 'foo',
    'Class [ExampleTest]:' => 'ExampleTest',
  ];

  protected $fixtures = [
    'tests/src/Functional/ExampleTest.php' => __DIR__ . '/_browser.php',
  ];

}
