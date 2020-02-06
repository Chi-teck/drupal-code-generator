<?php

namespace DrupalCodeGenerator\Tests\Generator;

/**
 * Test for theme-settings command.
 */
final class ThemeSettingsTest extends BaseGeneratorTest {

  protected $class = 'ThemeSettings';

  protected $interaction = [
    'Theme name [%default_name%]:' => 'Foo',
    'Theme machine name [foo]:' => 'foo',
  ];

  protected $fixtures = [
    'theme-settings.php' => '/_theme_settings_form.php',
    'config/install/foo.settings.yml' => '/_theme_settings_config.yml',
    'config/schema/foo.schema.yml' => '/_theme_settings_schema.yml',
  ];

}
