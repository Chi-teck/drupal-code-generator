<?php

namespace DrupalCodeGenerator\Tests\Generator\Drupal_8\Test;

use DrupalCodeGenerator\Tests\Generator\GeneratorTestCase;

/**
 * Test for d8:test:unit command.
 */
class UnitTest extends GeneratorTestCase {

  protected $class = 'Drupal_8\Test\Unit';

  protected $answers = [
    'Foo',
    'foo',
    'Example',
  ];

  protected $fixtures = [
    'tests/src/Unit/ExampleTest.php' => __DIR__ . '/_unit.php',
  ];

}
