<?php declare(strict_types=1);

namespace DrupalCodeGenerator\Tests\Generator\Test;

use DrupalCodeGenerator\Tests\Generator\BaseGeneratorTest;

/**
 * Test for test:unit command.
 */
final class UnitTest extends BaseGeneratorTest {

  protected string $class = 'Test\Unit';

  protected array $interaction = [
    'Module name [%default_name%]:' => 'Foo',
    'Module machine name [foo]:' => 'foo',
    'Class [ExampleTest]:' => 'ExampleTest',
  ];

  protected array $fixtures = [
    'tests/src/Unit/ExampleTest.php' => '/_unit.php',
  ];

}
