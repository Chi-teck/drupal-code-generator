<?php

namespace DrupalCodeGenerator\Tests\Generator\Drupal_8\Yml;

use DrupalCodeGenerator\Tests\Generator\GeneratorBaseTest;

/**
 * Test for d8:yml:services command.
 */
class ServicesTest extends GeneratorBaseTest {

  protected $class = 'Drupal_8\Yml\Services';

  protected $interaction = [
    'Module name [%default_name%]:' => 'Foo',
    'Module machine name [foo]:' => 'foo',
  ];
  protected $fixtures = [
    'foo.services.yml' => __DIR__ . '/_services.yml',
  ];

}
