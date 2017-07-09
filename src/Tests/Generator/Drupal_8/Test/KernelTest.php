<?php

namespace DrupalCodeGenerator\Tests\Generator\Drupal_8\Test;

use DrupalCodeGenerator\Tests\Generator\GeneratorBaseTest;

/**
 * Test for d8:test:kernel command.
 */
class KernelTest extends GeneratorBaseTest {

  protected $class = 'Drupal_8\Test\Kernel';

  protected $interaction = [
    'Module name [%default_name%]: ' => 'Foo',
    'Module machine name [foo]: ' => 'foo',
    'Class [ExampleTest]: ' => 'ExampleTest',
  ];

  protected $fixtures = [
    'tests/src/Kernel/ExampleTest.php' => __DIR__ . '/_kernel.php',
  ];

}
