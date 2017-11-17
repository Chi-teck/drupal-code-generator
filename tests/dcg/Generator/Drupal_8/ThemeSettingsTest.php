<?php

namespace DrupalCodeGenerator\Tests\Generator\Drupal_8;

use DrupalCodeGenerator\Tests\Generator\GeneratorBaseTest;

/**
 * Test for d8:theme-settings command.
 */
class ThemeSettingsTest extends GeneratorBaseTest {

  protected $class = 'Drupal_8\ThemeSettings';

  protected $interaction = [
    'Theme name [%default_name%]:' => 'Foo',
    'Theme machine name [foo]:' => 'foo',
  ];

  protected $fixtures = [
    'theme-settings.php' => __DIR__ . '/_theme_settings_form.php',
    'config/install/foo.settings.yml' => __DIR__ . '/_theme_settings_config.yml',
    'config/schema/foo.schema.yml' => __DIR__ . '/_theme_settings_schema.yml',
  ];

}
