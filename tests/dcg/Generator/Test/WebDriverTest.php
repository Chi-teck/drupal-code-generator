<?php declare(strict_types=1);

namespace DrupalCodeGenerator\Tests\Generator\Test;

use DrupalCodeGenerator\Tests\Generator\BaseGeneratorTest;

/**
 * Test for test:webdriver command.
 */
final class WebDriverTest extends BaseGeneratorTest {

  protected string $class = 'Test\WebDriver';

  protected array $interaction = [
    'Module name [%default_name%]:' => 'Foo',
    'Module machine name [foo]:' => 'foo',
    'Class [ExampleTest]:' => 'ExampleTest',
  ];

  protected array $fixtures = [
    'tests/src/FunctionalJavascript/ExampleTest.php' => '/_webdriver.php',
  ];

}
