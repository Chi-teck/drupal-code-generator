<?php

namespace DrupalCodeGenerator\Tests\Generator\Drupal_7;

use DrupalCodeGenerator\Tests\Generator\GeneratorBaseTest;

/**
 * Test for d7:info-file command.
 */
class ModuleInfoTest extends GeneratorBaseTest {

  protected $class = 'Drupal_7\ModuleInfo';

  protected $interaction = [
    'Module name [%default_name%]: ' => 'Example',
    'Module machine name [example]: ' => 'example',
    'Module description [Module description]: ' => 'Some description',
    'Package [Custom]: ' => 'Custom',
    'Version [7.x-1.0-dev]: ' => '7.x-1.0',
  ];

  protected $fixtures = [
    'example.info' => __DIR__ . '/_module.info',
  ];

}
