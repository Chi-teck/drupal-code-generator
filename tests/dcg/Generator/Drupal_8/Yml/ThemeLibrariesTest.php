<?php

namespace DrupalCodeGenerator\Tests\Generator\Drupal_8\Yml;

use DrupalCodeGenerator\Tests\Generator\GeneratorBaseTest;

/**
 * Test for d8:yml:theme-libraries command.
 */
class ThemeLibrariesTest extends GeneratorBaseTest {

  protected $class = 'Drupal_8\Yml\ThemeLibraries';

  protected $interaction = [
    'Theme machine name [%default_machine_name%]:' => 'example',
  ];

  protected $fixtures = [
    'example.libraries.yml' => __DIR__ . '/_theme_libraries.yml',
  ];

}
