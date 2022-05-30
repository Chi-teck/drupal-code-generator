<?php declare(strict_types=1);

namespace DrupalCodeGenerator\Tests\Functional\Generator;

use DrupalCodeGenerator\Command\Layout;
use DrupalCodeGenerator\Test\Functional\GeneratorTestBase;

/**
 * Tests layout generator.
 */
final class LayoutTest extends GeneratorTestBase {

  protected string $fixtureDir = __DIR__ . '/_layout';

  public function testGenerator(): void {
    $input = [
      'example',
      'Foo bar',
      'foo_bar',
      'My awesome layouts',
      'Yes',
      'Yes',
    ];
    $this->execute(Layout::class, $input);

    $expected_display = <<< 'TXT'

     Welcome to layout generator!
    ––––––––––––––––––––––––––––––

     Module machine name [%default_name%]:
     ➤ 

     Layout name [Example]:
     ➤ 

     Layout machine name [foo_bar]:
     ➤ 

     Category [My layouts]:
     ➤ 

     Would you like to create JavaScript file for this layout? [No]:
     ➤ 

     Would you like to create CSS file for this layout? [No]:
     ➤ 

     The following directories and files have been created or updated:
    –––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––
     • example.layouts.yml
     • example.libraries.yml
     • layouts/foo_bar/foo-bar.css
     • layouts/foo_bar/foo-bar.html.twig
     • layouts/foo_bar/foo-bar.js

    TXT;
    $this->assertDisplay($expected_display);

    $this->assertGeneratedFile('example.layouts.yml');
    $this->assertGeneratedFile('example.libraries.yml');
    $this->assertGeneratedFile('layouts/foo_bar/foo-bar.css');
    $this->assertGeneratedFile('layouts/foo_bar/foo-bar.html.twig');
    $this->assertGeneratedFile('layouts/foo_bar/foo-bar.js');
  }

}
