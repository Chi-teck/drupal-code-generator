<?php declare(strict_types=1);

namespace DrupalCodeGenerator\Tests\Functional\Generator\Yaml;

use DrupalCodeGenerator\Command\Yml\ThemeInfo;
use DrupalCodeGenerator\Test\Functional\GeneratorTestBase;

/**
 * Tests yml:theme-info generator.
 */
final class ThemeInfoTest extends GeneratorTestBase {

  protected string $fixtureDir = __DIR__ . '/_theme_info';

  public function testGenerator(): void {
    $input = [
      'example',
      'garland',
      'Example description.',
      'Custom',
    ];
    $this->execute(ThemeInfo::class, $input);

    $expected_display = <<< 'TXT'

     Welcome to theme-info generator!
    ––––––––––––––––––––––––––––––––––

     Theme machine name [%default_name%]:
     ➤ 

     Base theme [classy]:
     ➤ 

     Description [A flexible theme with a responsive, mobile-first layout.]:
     ➤ 

     Package [Custom]:
     ➤ 

     The following directories and files have been created or updated:
    –––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––
     • example.info.yml

    TXT;
    $this->assertDisplay($expected_display);

    $this->assertGeneratedFile('example.info.yml');
  }

}
