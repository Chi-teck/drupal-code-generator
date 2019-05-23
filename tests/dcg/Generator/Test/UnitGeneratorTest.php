<?php

namespace DrupalCodeGenerator\Tests\Generator\Test;

use DrupalCodeGenerator\Tests\Generator\BaseGeneratorTest;

/**
 * Test for test:unit command.
 */
class UnitGeneratorTest extends BaseGeneratorTest {

  protected $class = 'Test\Unit';

  protected $interaction = [
    'Module name [%default_name%]:' => 'Foo',
    'Module machine name [foo]:' => 'foo',
    'Class [ExampleTest]:' => 'ExampleTest',
  ];

  protected $fixtures = [
    'tests/src/Unit/ExampleTest.php' => __DIR__ . '/_unit.php',
  ];

}
