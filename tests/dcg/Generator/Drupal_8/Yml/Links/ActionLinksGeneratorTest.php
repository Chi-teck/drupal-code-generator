<?php

namespace DrupalCodeGenerator\Tests\Generator\Drupal_8\Yml\Links;

use DrupalCodeGenerator\Tests\Generator\BaseGeneratorTest;

/**
 * Test for d8:yml:links:action command.
 */
class ActionLinksGeneratorTest extends BaseGeneratorTest {

  protected $class = 'Drupal_8\Yml\Links\Action';

  protected $interaction = [
    'Module machine name [%default_machine_name%]:' => 'example',
  ];

  protected $fixtures = [
    'example.links.action.yml' => __DIR__ . '/_links.action.yml',
  ];

}
