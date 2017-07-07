<?php

namespace DrupalCodeGenerator\Tests\Generator\Drupal_8\Yml;

use DrupalCodeGenerator\Tests\Generator\GeneratorBaseTest;

/**
 * Test for d8:yml:contextual-links command.
 */
class ContextualLinksTest extends GeneratorBaseTest {

  protected $class = 'Drupal_8\Yml\ContextualLinks';

  protected $interaction = [
    'Module machine name [%default_machine_name%]: ' => 'example',
  ];

  protected $fixtures = [
    'example.links.contextual.yml' => __DIR__ . '/_links.contextual.yml',
  ];

}
