<?php declare(strict_types = 1);

namespace DrupalCodeGenerator\Tests\Functional\Generator;

use DrupalCodeGenerator\Command\Theme;
use DrupalCodeGenerator\Test\Functional\GeneratorTestBase;

/**
 * Tests theme generator.
 */
final class ThemeTest extends GeneratorTestBase {

  protected string $fixtureDir = __DIR__ . '/_theme';

  public function testGenerator(): void {

    $input = [
      'Foo',
      'foo',
      'bartik',
      'Some description.',
      'Custom',
      'Yes',
      'Yes',
    ];
    $this->execute(Theme::class, $input);

    $expected_display = <<< 'TXT'

     Welcome to theme generator!
    –––––––––––––––––––––––––––––

     Theme name:
     ➤ 

     Theme machine name [foo]:
     ➤ 

     Base theme [classy]:
     ➤ 

     Description [A flexible theme with a responsive, mobile-first layout.]:
     ➤ 

     Package [Custom]:
     ➤ 

     Would you like to create breakpoints? [No]:
     ➤ 

     Would you like to create theme settings form? [No]:
     ➤ 

     The following directories and files have been created or updated:
    –––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––
     • foo/css
     • foo/images
     • foo/templates/block
     • foo/templates/field
     • foo/templates/menu
     • foo/templates/node
     • foo/templates/page
     • foo/templates/view
     • foo/foo.breakpoints.yml
     • foo/foo.info.yml
     • foo/foo.libraries.yml
     • foo/foo.theme
     • foo/logo.svg
     • foo/package.json
     • foo/theme-settings.php
     • foo/config/install/foo.settings.yml
     • foo/config/schema/foo.schema.yml
     • foo/css/base/elements.css
     • foo/css/components/block.css
     • foo/css/components/breadcrumb.css
     • foo/css/components/buttons.css
     • foo/css/components/field.css
     • foo/css/components/form.css
     • foo/css/components/header.css
     • foo/css/components/menu.css
     • foo/css/components/messages.css
     • foo/css/components/node.css
     • foo/css/components/sidebar.css
     • foo/css/components/table.css
     • foo/css/components/tabs.css
     • foo/css/layouts/layout.css
     • foo/css/theme/print.css
     • foo/js/foo.js

    TXT;
    $this->assertDisplay($expected_display);

    $this->assertGeneratedDirectory('foo/css');
    $this->assertGeneratedDirectory('foo/images');
    $this->assertGeneratedDirectory('foo/templates/block');
    $this->assertGeneratedDirectory('foo/templates/field');
    $this->assertGeneratedDirectory('foo/templates/menu');
    $this->assertGeneratedDirectory('foo/templates/node');
    $this->assertGeneratedDirectory('foo/templates/page');
    $this->assertGeneratedDirectory('foo/templates/view');

    $this->assertGeneratedFile('foo/foo.breakpoints.yml');
    $this->assertGeneratedFile('foo/foo.info.yml');
    $this->assertGeneratedFile('foo/foo.libraries.yml');
    $this->assertGeneratedFile('foo/foo.theme');
    $this->assertGeneratedFile('foo/logo.svg');
    $this->assertGeneratedFile('foo/package.json');
    $this->assertGeneratedFile('foo/theme-settings.php');
    $this->assertGeneratedFile('foo/config/install/foo.settings.yml');
    $this->assertGeneratedFile('foo/config/schema/foo.schema.yml');
    $this->assertGeneratedFile('foo/js/foo.js');
  }

}
