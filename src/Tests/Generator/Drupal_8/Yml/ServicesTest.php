<?php

namespace DrupalCodeGenerator\Tests\Generator\Drupal_8\Yml;

use DrupalCodeGenerator\Tests\Generator\GeneratorTestCase;

/**
 * Test for d8:yml:services command.
 */
class ServicesTest extends GeneratorTestCase {

  protected $class = 'Drupal_8\Yml\Services';
  protected $answers = [
    'Foo',
    'foo',
  ];
  protected $fixtures = [
    'foo.services.yml' => __DIR__ . '/_services.yml',
  ];

}
