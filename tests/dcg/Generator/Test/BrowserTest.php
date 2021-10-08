<?php declare(strict_types=1);

namespace DrupalCodeGenerator\Tests\Generator\Test;

use DrupalCodeGenerator\Tests\Generator\BaseGeneratorTest;

/**
 * Test for test:browser command.
 */
final class BrowserTest extends BaseGeneratorTest {

  protected string $class = 'Test\Browser';

  protected array $interaction = [
    'Module name [%default_name%]:' => 'Foo',
    'Module machine name [foo]:' => 'foo',
    'Class [ExampleTest]:' => 'ExampleTest',
  ];

  protected array $fixtures = [
    'tests/src/Functional/ExampleTest.php' => '/_browser.php',
  ];

}
