<?php declare(strict_types=1);

namespace DrupalCodeGenerator\Tests\Generator\Test;

use DrupalCodeGenerator\Tests\Generator\BaseGeneratorTest;

/**
 * Test for test:kernel command.
 */
final class KernelTest extends BaseGeneratorTest {

  protected string $class = 'Test\Kernel';

  protected array $interaction = [
    'Module name [%default_name%]:' => 'Foo',
    'Module machine name [foo]:' => 'foo',
    'Class [ExampleTest]:' => 'ExampleTest',
  ];

  protected array $fixtures = [
    'tests/src/Kernel/ExampleTest.php' => '/_kernel.php',
  ];

}
