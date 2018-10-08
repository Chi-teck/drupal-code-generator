<?php

namespace DrupalCodeGenerator\Tests\Generator\Drupal_7;

use DrupalCodeGenerator\Tests\Generator\GeneratorBaseTest;

/**
 * Test for d7:module command.
 */
class ModuleTest extends GeneratorBaseTest {

  protected $class = 'Drupal_7\Module';

  protected $interaction = [
    'Module name [%default_name%]:' => 'Example',
    'Module machine name [example]:' => 'example',
    'Module description [Module description.]:' => 'Some description.',
    'Package [Custom]:' => 'Custom',
  ];

  protected $fixtures = [
    'example/example.admin.inc' => __DIR__ . '/_module_admin.inc',
    'example/example.info' => __DIR__ . '/_module.info',
    'example/example.install' => __DIR__ . '/_.install',
    'example/example.js' => __DIR__ . '/_module.js',
    'example/example.module' => __DIR__ . '/_.module',
    'example/example.pages.inc' => __DIR__ . '/_module_pages.inc',
  ];

}
