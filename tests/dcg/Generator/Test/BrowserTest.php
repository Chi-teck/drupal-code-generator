<?php

namespace DrupalCodeGenerator\Tests\Generator\Test;

use DrupalCodeGenerator\Tests\Generator\BaseGeneratorTest;

/**
 * Test for test:browser command.
 */
class BrowserTest extends BaseGeneratorTest {

  protected $class = 'Test\Browser';

  protected $interaction = [
    'Module name [%default_name%]:' => 'Foo',
    'Module machine name [foo]:' => 'foo',
    'Class [ExampleTest]:' => 'ExampleTest',
  ];

  protected $fixtures = [
    'tests/src/Functional/ExampleTest.php' => '/_browser.php',
  ];

}
