<?php

declare(strict_types=1);

namespace DrupalCodeGenerator\Tests\Functional\Generator\Yaml;

use DrupalCodeGenerator\Command\Yml\ThemeLibraries;
use DrupalCodeGenerator\Test\Functional\GeneratorTestBase;

/**
 * Tests yml:theme-libraries generator.
 */
final class ThemeLibrariesTest extends GeneratorTestBase {

  protected string $fixtureDir = __DIR__ . '/_theme_libraries';

  public function testGenerator(): void {
    $this->execute(ThemeLibraries::class, ['example']);

    $expected_display = <<< 'TXT'

     Welcome to theme-libraries generator!
    –––––––––––––––––––––––––––––––––––––––

     Theme machine name:
     ➤ 

     The following directories and files have been created or updated:
    –––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––
     • example.libraries.yml

    TXT;
    $this->assertDisplay($expected_display);

    $this->assertGeneratedFile('example.libraries.yml');
  }

}
