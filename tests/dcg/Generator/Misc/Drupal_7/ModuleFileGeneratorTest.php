<?php

namespace DrupalCodeGenerator\Tests\Generator\Misc\Drupal_7;

use DrupalCodeGenerator\Tests\Generator\BaseGeneratorTest;

/**
 * Test for misc:d7:module-file command.
 */
class ModuleFileGeneratorTest extends BaseGeneratorTest {

  protected $class = 'Misc\Drupal_7\ModuleFile';

  protected $interaction = [
    'Module name [%default_name%]:' => 'Example',
    'Module machine name [example]:' => 'example',
  ];

  protected $fixtures = [
    'example.module' => __DIR__ . '/_.module',
  ];

}
