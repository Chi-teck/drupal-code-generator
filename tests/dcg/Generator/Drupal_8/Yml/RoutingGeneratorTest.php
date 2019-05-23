<?php

namespace DrupalCodeGenerator\Tests\Generator\Drupal_8\Yml;

use DrupalCodeGenerator\Tests\Generator\BaseGeneratorTest;

/**
 * Test for yml:routing command.
 */
class RoutingGeneratorTest extends BaseGeneratorTest {

  protected $class = 'Yml\Routing';

  protected $interaction = [
    'Module name [%default_name%]:' => 'Example',
    'Module machine name [example]:' => 'example',
  ];

  protected $fixtures = [
    'example.routing.yml' => __DIR__ . '/_routing.yml',
  ];

}
