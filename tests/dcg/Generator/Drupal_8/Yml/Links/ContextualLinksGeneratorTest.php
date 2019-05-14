<?php

namespace DrupalCodeGenerator\Tests\Generator\Drupal_8\Yml\Links;

use DrupalCodeGenerator\Tests\Generator\BaseGeneratorTest;

/**
 * Test for d8:yml:links:contextual command.
 */
class ContextualLinksGeneratorTest extends BaseGeneratorTest {

  protected $class = 'Drupal_8\Yml\Links\Contextual';

  protected $interaction = [
    'Module machine name [%default_machine_name%]:' => 'example',
  ];

  protected $fixtures = [
    'example.links.contextual.yml' => __DIR__ . '/_links.contextual.yml',
  ];

}
