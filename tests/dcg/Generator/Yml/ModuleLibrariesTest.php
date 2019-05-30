<?php

namespace DrupalCodeGenerator\Tests\Generator\Yml;

use DrupalCodeGenerator\Tests\Generator\BaseGeneratorTest;

/**
 * Test for yml:module-libraries command.
 */
class ModuleLibrariesTest extends BaseGeneratorTest {

  protected $class = 'Yml\ModuleLibraries';

  protected $interaction = [
    'Module machine name [%default_machine_name%]:' => 'example',
  ];

  protected $fixtures = [
    'example.libraries.yml' => '/_module_libraries.yml',
  ];

}
