<?php

namespace DrupalCodeGenerator\Tests\Generator\Drupal_7;

use DrupalCodeGenerator\Tests\Generator\GeneratorTestCase;

/**
 * Test for d7:info-file command.
 */
class ModuleInfoTest extends GeneratorTestCase {

  protected $class = 'Drupal_7\ModuleInfo';

  protected $answers = [
    'Example',
    'example',
    'Some description',
    'custom',
    '7.x-1.0',
  ];

  protected $fixtures = [
    'example.info' => __DIR__ . '/_module.info',
  ];

}
