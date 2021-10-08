<?php declare(strict_types=1);

namespace DrupalCodeGenerator\Tests\Generator;

use DrupalCodeGenerator\Command\ThemeSettings;
use DrupalCodeGenerator\Test\GeneratorTest;

/**
 * Test for theme-settings command.
 */
final class ThemeSettingsTest extends GeneratorTest {

  protected $fixtureDir = __DIR__;

  /**
   * Test callback.
   */
  public function testGenerator(): void {

    $this->execute(new ThemeSettings(), ['Foo', 'foo']);

    $expected_display = <<< 'TXT'

     Welcome to theme-settings generator!
    ––––––––––––––––––––––––––––––––––––––

     Theme name [%default_name%]:
     ➤ 

     Theme machine name [foo]:
     ➤ 

     The following directories and files have been created or updated:
    –––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––
     • theme-settings.php
     • config/install/foo.settings.yml
     • config/schema/foo.schema.yml


    TXT;
    $this->assertDisplay($expected_display);

    $this->assertGeneratedFile('theme-settings.php', '_theme_settings_form.php');
    $this->assertGeneratedFile('config/install/foo.settings.yml', '_theme_settings_config.yml');
    $this->assertGeneratedFile('config/schema/foo.schema.yml', '_theme_settings_schema.yml');
  }

}
