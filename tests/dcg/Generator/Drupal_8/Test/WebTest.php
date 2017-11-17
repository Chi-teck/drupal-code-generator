<?php

namespace DrupalCodeGenerator\Tests\Generator\Drupal_8\Test;

use DrupalCodeGenerator\Tests\Generator\GeneratorBaseTest;

/**
 * Test for d8:test:web command.
 */
class WebTest extends GeneratorBaseTest {

  protected $class = 'Drupal_8\Test\Web';

  protected $interaction = [
    'Module name [%default_name%]:' => 'Foo',
    'Module machine name [foo]:' => 'foo',
    'Class [ExampleTest]:' => 'ExampleTest',
  ];

  protected $fixtures = [
    'src/Tests/ExampleTest.php' => __DIR__ . '/_web.php',
  ];

}
