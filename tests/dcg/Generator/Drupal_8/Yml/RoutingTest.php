<?php

namespace DrupalCodeGenerator\Tests\Generator\Drupal_8\Yml;

use DrupalCodeGenerator\Tests\Generator\GeneratorBaseTest;

/**
 * Test for d8:yml:routing command.
 */
class RoutingTest extends GeneratorBaseTest {

  protected $class = 'Drupal_8\Yml\Routing';

  protected $interaction = [
    'Module name [%default_name%]: ' => 'Example',
    'Module machine name [example]: ' => 'example',
  ];

  protected $fixtures = [
    'example.routing.yml' => __DIR__ . '/_routing.yml',
  ];

}
