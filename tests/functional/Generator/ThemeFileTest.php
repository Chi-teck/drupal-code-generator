<?php declare(strict_types=1);

namespace DrupalCodeGenerator\Tests\Functional\Generator;

use DrupalCodeGenerator\Command\ThemeFile;
use DrupalCodeGenerator\Test\Functional\GeneratorTestBase;

/**
 * Tests theme-file generator.
 */
final class ThemeFileTest extends GeneratorTestBase {

  protected string $fixtureDir = __DIR__ . '/_theme_file';

  public function testGenerator(): void {

    $this->execute(new ThemeFile(), ['foo']);

    $expected_display = <<< 'TXT'

     Welcome to theme-file generator!
    ––––––––––––––––––––––––––––––––––

     Theme machine name [%default_name%]:
     ➤ 

     The following directories and files have been created or updated:
    –––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––
     • foo.theme

    TXT;
    $this->assertDisplay($expected_display);

    $this->assertGeneratedFile('foo.theme');
  }

}
