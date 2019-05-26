<?php

namespace DrupalCodeGenerator\Tests\Generator\Misc\Drupal_7;

use DrupalCodeGenerator\Tests\Generator\BaseGeneratorTest;

/**
 * Test for misc:d7:module command.
 */
class ModuleTest extends BaseGeneratorTest {

  protected $class = 'Misc\Drupal_7\Module';

  protected $interaction = [
    'Module name [%default_name%]:' => 'Example',
    'Module machine name [example]:' => 'example',
    'Module description [Module description.]:' => 'Some description.',
    'Package [Custom]:' => 'Custom',
  ];

  protected $fixtures = [
    'example/example.admin.inc' => __DIR__ . '/_module/example.admin.inc',
    'example/example.info' => __DIR__ . '/_module/example.info',
    'example/example.install' => __DIR__ . '/_module/example.install',
    'example/example.js' => __DIR__ . '/_module/example.js',
    'example/example.module' => __DIR__ . '/_module/example.module',
    'example/example.pages.inc' => __DIR__ . '/_module/example.pages.inc',
  ];

}
