<?php declare(strict_types=1);

namespace DrupalCodeGenerator\Tests\Functional\Generator;

use DrupalCodeGenerator\Command\ThemeSettings;
use DrupalCodeGenerator\Test\Functional\GeneratorTestBase;

/**
 * Tests theme-settings generator.
 */
final class ThemeSettingsTest extends GeneratorTestBase {

  protected string $fixtureDir = __DIR__ . '/_theme_settings';

  public function testGenerator(): void {

    $this->execute(ThemeSettings::class, ['foo']);

    $expected_display = <<< 'TXT'

     Welcome to theme-settings generator!
    ––––––––––––––––––––––––––––––––––––––

     Theme machine name:
     ➤ 
     
     Theme name [Foo]:
     ➤ 

     The following directories and files have been created or updated:
    –––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––
     • theme-settings.php
     • config/install/foo.settings.yml
     • config/schema/foo.schema.yml

    TXT;
    $this->assertDisplay($expected_display);

    $this->assertGeneratedFile('theme-settings.php');
    $this->assertGeneratedFile('config/install/foo.settings.yml');
    $this->assertGeneratedFile('config/schema/foo.schema.yml');
  }

}
