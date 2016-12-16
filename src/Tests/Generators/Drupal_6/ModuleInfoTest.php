<?php

namespace DrupalCodeGenerator\Tests\Drupal_6;

use DrupalCodeGenerator\Tests\GeneratorTestCase;

/**
 * Test for d6:module-info-file command.
 */
class ModuleInfoTest extends GeneratorTestCase {

  protected $class = 'Drupal_6\ModuleInfo';
  protected $answers = [
    'Example',
    'example',
    'Some description',
    'custom',
    '6.x-1.0',
  ];
  protected $fixtures = [
    'example.info' => __DIR__ . '/_module_info.info',
  ];

}
