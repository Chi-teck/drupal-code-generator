<?php declare(strict_types=1);

namespace DrupalCodeGenerator\Tests\Functional\Generator\Test;

use DrupalCodeGenerator\Command\Test\WebDriver;
use DrupalCodeGenerator\Test\Functional\GeneratorTestBase;

/**
 * Tests test:webdriver generator.
 */
final class WebDriverTest extends GeneratorTestBase {

  protected string $fixtureDir = __DIR__ . '/_web_driver';

  public function testGenerator(): void {

    $this->execute(WebDriver::class, ['foo', 'ExampleTest']);

    $expected_display = <<< 'TXT'

     Welcome to webdriver-test generator!
    ––––––––––––––––––––––––––––––––––––––

     Module machine name [%default_name%]:
     ➤ 

     Class [ExampleTest]:
     ➤ 

     The following directories and files have been created or updated:
    –––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––
     • tests/src/FunctionalJavascript/ExampleTest.php

    TXT;
    $this->assertDisplay($expected_display);

    $this->assertGeneratedFile('tests/src/FunctionalJavascript/ExampleTest.php');
  }

}
