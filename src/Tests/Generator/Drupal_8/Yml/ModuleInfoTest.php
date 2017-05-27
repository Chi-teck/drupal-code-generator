<?php

namespace DrupalCodeGenerator\Tests\Generator\Drupal_8\Yml;

use DrupalCodeGenerator\Tests\Generator\GeneratorTestCase;

/**
 * Test for d8:yml:module-info command.
 */
class ModuleInfoTest extends GeneratorTestCase {

  protected $class = 'Drupal_8\Yml\ModuleInfo';

  protected $answers = [
    'Example',
    'example',
    'Example description.',
    'custom',
    '8.x-1.0-dev',
    'example.settings',
    'views, node, fields',
  ];

  protected $fixtures = [
    'example.info.yml' => __DIR__ . '/_module_info.yml',
  ];

}
