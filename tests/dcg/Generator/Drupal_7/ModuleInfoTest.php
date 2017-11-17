<?php

namespace DrupalCodeGenerator\Tests\Generator\Drupal_7;

use DrupalCodeGenerator\Tests\Generator\GeneratorBaseTest;

/**
 * Test for d7:module-info command.
 */
class ModuleInfoTest extends GeneratorBaseTest {

  protected $class = 'Drupal_7\ModuleInfo';

  protected $interaction = [
    'Module name [%default_name%]:' => 'Example',
    'Module machine name [example]:' => 'example',
    'Module description [Module description.]:' => 'Some description.',
    'Package [Custom]:' => 'Custom',
  ];

  protected $fixtures = [
    'example.info' => __DIR__ . '/_module.info',
  ];

}
