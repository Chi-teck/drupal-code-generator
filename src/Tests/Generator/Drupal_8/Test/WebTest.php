<?php

namespace DrupalCodeGenerator\Tests\Generator\Drupal_8\Test;

use DrupalCodeGenerator\Tests\Generator\GeneratorTestCase;

/**
 * Test for d8:test:web command.
 */
class WebTest extends GeneratorTestCase {

  protected $class = 'Drupal_8\Test\Web';

  protected $answers = [
    'Foo',
    'foo',
    'Example',
  ];

  protected $fixtures = [
    'src/Tests/ExampleTest.php' => __DIR__ . '/_web.php',
  ];

}
