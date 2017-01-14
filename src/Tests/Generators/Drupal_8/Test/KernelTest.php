<?php

namespace DrupalCodeGenerator\Tests\Drupal_8\Test;

use DrupalCodeGenerator\Tests\GeneratorTestCase;

/**
 * Test for d8:test:kernel command.
 */
class KernelTest extends GeneratorTestCase {

  protected $class = 'Drupal_8\Test\Kernel';

  protected $answers = [
    'Foo',
    'foo',
    'Example',
  ];

  protected $fixtures = [
    'tests/src/Kernel/ExampleTest.php' => __DIR__ . '/_kernel.php',
  ];

}
