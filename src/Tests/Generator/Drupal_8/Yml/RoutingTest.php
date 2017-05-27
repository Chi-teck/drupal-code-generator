<?php

namespace DrupalCodeGenerator\Tests\Generator\Drupal_8\Yml;

use DrupalCodeGenerator\Tests\Generator\GeneratorTestCase;

/**
 * Test for d8:yml:routing command.
 */
class RoutingTest extends GeneratorTestCase {

  protected $class = 'Drupal_8\Yml\Routing';

  protected $answers = [
    'Example',
    'example',
  ];

  protected $fixtures = [
    'example.routing.yml' => __DIR__ . '/_routing.yml',
  ];

}
