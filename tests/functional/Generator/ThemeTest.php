<?php

declare(strict_types=1);

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

     Base theme [claro]:
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
     • foo/css/component/block.css
     • foo/css/component/breadcrumb.css
     • foo/css/component/buttons.css
     • foo/css/component/field.css
     • foo/css/component/form.css
     • foo/css/component/header.css
     • foo/css/component/menu.css
     • foo/css/component/messages.css
     • foo/css/component/node.css
     • foo/css/component/sidebar.css
     • foo/css/component/table.css
     • foo/css/component/tabs.css
     • foo/css/layout/layout.css
     • foo/css/theme/print.css
     • foo/js/foo.js

    TXT;
    $this->assertDisplay($expected_display);

    // For CSS just check the directories to reduce the number of fixtures.
    $this->assertGeneratedDirectory('foo/css/base');
    $this->assertGeneratedDirectory('foo/css/component');
    $this->assertGeneratedDirectory('foo/css/layout');
    $this->assertGeneratedDirectory('foo/css/theme');
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
