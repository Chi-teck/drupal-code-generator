<?php

namespace DrupalCodeGenerator\Tests\Generator\Drupal_8\Yml;

use DrupalCodeGenerator\Tests\Generator\BaseGeneratorTest;

/**
 * Test for yml:module-info command.
 */
class ModuleInfoGeneratorTest extends BaseGeneratorTest {

  protected $class = 'Yml\ModuleInfo';

  protected $interaction = [
    'Module name [%default_name%]:' => 'Example',
    'Module machine name [example]:' => 'example',
    'Description [Module description.]:' => 'Example description.',
    'Package [Custom]:' => 'Custom',
    'Configuration page (route name):' => 'example.settings',
    'Dependencies (comma separated):' => 'views, node, fields',
  ];

  protected $fixtures = [
    'example.info.yml' => __DIR__ . '/_module_info.yml',
  ];

}
