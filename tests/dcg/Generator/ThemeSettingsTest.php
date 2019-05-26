<?php

namespace DrupalCodeGenerator\Tests\Generator;

/**
 * Test for theme-settings command.
 */
class ThemeSettingsTest extends BaseGeneratorTest {

  protected $class = 'ThemeSettings';

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
