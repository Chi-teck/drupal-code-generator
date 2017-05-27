<?php

namespace DrupalCodeGenerator\Tests\Generator\Drupal_8;

use DrupalCodeGenerator\Tests\Generator\GeneratorTestCase;

/**
 * Test for d8:module-file command.
 */
class ModuleFileTest extends GeneratorTestCase {

  protected $class = 'Drupal_8\ModuleFile';

  protected $answers = [
    'Foo',
    'foo',
  ];

  protected $fixtures = [
    'foo.module' => __DIR__ . '/_module_file.module',
  ];

}
