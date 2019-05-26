<?php

namespace DrupalCodeGenerator\Tests\Generator\Yml;

use DrupalCodeGenerator\Tests\Generator\BaseGeneratorTest;

/**
 * Test for yml:theme-libraries command.
 */
class ThemeLibrariesTest extends BaseGeneratorTest {

  protected $class = 'Yml\ThemeLibraries';

  protected $interaction = [
    'Theme machine name [%default_machine_name%]:' => 'example',
  ];

  protected $fixtures = [
    'example.libraries.yml' => __DIR__ . '/_theme_libraries.yml',
  ];

}
