<?php

namespace DrupalCodeGenerator\Tests\Drupal_8\Yml;

use DrupalCodeGenerator\Tests\GeneratorTestCase;

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
