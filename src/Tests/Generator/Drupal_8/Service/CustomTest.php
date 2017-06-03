<?php

namespace DrupalCodeGenerator\Tests\Generator\Drupal_8\Service;

use DrupalCodeGenerator\Tests\Generator\GeneratorTestCase;

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
    'foo.services.yml' => __DIR__ . '/_custom.services.yml',
  ];

}
