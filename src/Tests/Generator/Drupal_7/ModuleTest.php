<?php

namespace DrupalCodeGenerator\Tests\Generator\Drupal_7;

use DrupalCodeGenerator\Tests\Generator\GeneratorTestCase;

/**
 * Test for d7:module-file command.
 */
class ModuleFileTest extends GeneratorTestCase {

  protected $class = 'Drupal_7\ModuleFile';

  protected $answers = [
    'Example',
    'example',
  ];

  protected $fixtures = [
    'example.module' => __DIR__ . '/_module_file.module',
  ];

}
