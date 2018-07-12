<?php

namespace DrupalCodeGenerator\Tests\Generator\Drupal_8\Test;

use DrupalCodeGenerator\Tests\Generator\GeneratorBaseTest;

/**
 * Test for d8:test:webdriver command.
 */
class WebDriverTest extends GeneratorBaseTest {

  protected $class = 'Drupal_8\Test\WebDriver';

  protected $interaction = [
    'Module name [%default_name%]:' => 'Foo',
    'Module machine name [foo]:' => 'foo',
    'Class [ExampleTest]:' => 'ExampleTest',
  ];

  protected $fixtures = [
    'tests/src/FunctionalJavascript/ExampleTest.php' => __DIR__ . '/_webdriver.php',
  ];

}
