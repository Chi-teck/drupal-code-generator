<?php

namespace DrupalCodeGenerator\Tests\Drupal_8\Service;

use DrupalCodeGenerator\Tests\GeneratorTestCase;

/**
 * Test for d8:service:custom command.
 */
class CustomTest extends GeneratorTestCase {

  protected $class = 'Drupal_8\Service\Custom';

  protected $answers = [
    'Foo',
    'foo',
    'foo.example',
    'Example',
  ];

  protected $fixtures = [
    'src/Example.php' => __DIR__ . '/_custom.php',
  ];

}
