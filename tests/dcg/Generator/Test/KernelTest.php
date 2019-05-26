<?php

namespace DrupalCodeGenerator\Tests\Generator\Test;

use DrupalCodeGenerator\Tests\Generator\BaseGeneratorTest;

/**
 * Test for test:kernel command.
 */
class KernelTest extends BaseGeneratorTest {

  protected $class = 'Test\Kernel';

  protected $interaction = [
    'Module name [%default_name%]:' => 'Foo',
    'Module machine name [foo]:' => 'foo',
    'Class [ExampleTest]:' => 'ExampleTest',
  ];

  protected $fixtures = [
    'tests/src/Kernel/ExampleTest.php' => __DIR__ . '/_kernel.php',
  ];

}
