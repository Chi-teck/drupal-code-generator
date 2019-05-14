<?php

namespace DrupalCodeGenerator\Tests\Generator\Drupal_8\Yml;

use DrupalCodeGenerator\Tests\Generator\BaseGeneratorTest;

/**
 * Test for d8:yml:module-libraries command.
 */
class ModuleLibrariesGeneratorTest extends BaseGeneratorTest {

  protected $class = 'Drupal_8\Yml\ModuleLibraries';

  protected $interaction = [
    'Module machine name [%default_machine_name%]:' => 'example',
  ];

  protected $fixtures = [
    'example.libraries.yml' => __DIR__ . '/_module_libraries.yml',
  ];

}
