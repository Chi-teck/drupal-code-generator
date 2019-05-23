<?php

namespace DrupalCodeGenerator\Tests\Generator\Drupal_8\Test;

use DrupalCodeGenerator\Tests\Generator\BaseGeneratorTest;

/**
 * Test for test:kernel command.
 */
class KernelGeneratorTest extends BaseGeneratorTest {

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
