<?php

namespace DrupalCodeGenerator\Tests\Generator\Drupal_7;

use DrupalCodeGenerator\Tests\Generator\GeneratorBaseTest;

/**
 * Test for d7:module-file command.
 */
class ModuleFileTest extends GeneratorBaseTest {

  protected $class = 'Drupal_7\ModuleFile';

  protected $interaction = [
    'Module name [%default_name%]: ' => 'Example',
    'Module machine name [example]: ' => 'example',
  ];

  protected $fixtures = [
    'example.module' => __DIR__ . '/_.module',
  ];

}
