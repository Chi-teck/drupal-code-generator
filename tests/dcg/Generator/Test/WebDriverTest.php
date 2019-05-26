<?php

namespace DrupalCodeGenerator\Tests\Generator\Test;

use DrupalCodeGenerator\Tests\Generator\BaseGeneratorTest;

/**
 * Test for test:webdriver command.
 */
class WebDriverTest extends BaseGeneratorTest {

  protected $class = 'Test\WebDriver';

  protected $interaction = [
    'Module name [%default_name%]:' => 'Foo',
    'Module machine name [foo]:' => 'foo',
    'Class [ExampleTest]:' => 'ExampleTest',
  ];

  protected $fixtures = [
    'tests/src/FunctionalJavascript/ExampleTest.php' => __DIR__ . '/_webdriver.php',
  ];

}
