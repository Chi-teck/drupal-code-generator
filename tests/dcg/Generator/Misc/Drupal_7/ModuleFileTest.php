<?php

namespace DrupalCodeGenerator\Tests\Generator\Misc\Drupal_7;

use DrupalCodeGenerator\Tests\Generator\BaseGeneratorTest;

/**
 * Test for misc:d7:module-file command.
 */
class ModuleFileTest extends BaseGeneratorTest {

  protected $class = 'Misc\Drupal_7\ModuleFile';

  protected $interaction = [
    'Module name [%default_name%]:' => 'Example',
    'Module machine name [example]:' => 'example',
  ];

  protected $fixtures = [
    'example.module' => '/_.module',
  ];

}
