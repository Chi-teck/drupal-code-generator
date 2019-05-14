<?php

namespace DrupalCodeGenerator\Tests\Generator\Drupal_8;

use DrupalCodeGenerator\Tests\Generator\BaseGeneratorTest;

/**
 * Test for d8:module-file command.
 */
class ModuleFileGeneratorTest extends BaseGeneratorTest {

  protected $class = 'Drupal_8\ModuleFile';

  protected $interaction = [
    'Module name [%default_name%]:' => 'Foo',
    'Module machine name [foo]:' => 'foo',
  ];

  protected $fixtures = [
    'foo.module' => __DIR__ . '/_module_file.module',
  ];

}
