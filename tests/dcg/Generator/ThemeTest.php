<?php

namespace DrupalCodeGenerator\Tests\Generator;

use DrupalCodeGenerator\Command\Theme;
use DrupalCodeGenerator\Test\GeneratorTest;

/**
 * Test for theme generator.
 */
final class ThemeTest extends GeneratorTest {

  protected $fixtureDir = __DIR__;

  /**
   * Test callback.
   */
  public function testGenerator(): void {

    $input = [
      'Foo',
      'foo',
      'bartik',
      'Some description.',
      'Custom',
      'Yes',
      'Yes',
      'Yes',
    ];
    $this->execute(new Theme(), $input);

    $expected_display = <<< 'TXT'

     Welcome to theme generator!
    –––––––––––––––––––––––––––––

     Theme name [%default_name%]:
     ➤ 

     Theme machine name [foo]:
     ➤ 

     Base theme [classy]:
     ➤ 

     Description [A flexible theme with a responsive, mobile-first layout.]:
     ➤ 

     Package [Custom]:
     ➤ 

     Would you like to use SASS to compile style sheets? [No]:
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
     • foo/js/foo.js
     • foo/scss/base/elements.scss
     • foo/scss/components/block.scss
     • foo/scss/components/breadcrumb.scss
     • foo/scss/components/buttons.scss
     • foo/scss/components/field.scss
     • foo/scss/components/form.scss
     • foo/scss/components/header.scss
     • foo/scss/components/menu.scss
     • foo/scss/components/messages.scss
     • foo/scss/components/node.scss
     • foo/scss/components/sidebar.scss
     • foo/scss/components/table.scss
     • foo/scss/components/tabs.scss
     • foo/scss/layouts/layout.scss
     • foo/scss/theme/print.scss


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

    $this->assertGeneratedFile('foo/foo.breakpoints.yml', '/_theme/foo.breakpoints.yml');
    $this->assertGeneratedFile('foo/foo.info.yml', '/_theme/foo.info.yml');
    $this->assertGeneratedFile('foo/foo.libraries.yml', '/_theme/foo.libraries.yml');
    $this->assertGeneratedFile('foo/foo.theme', '/_theme/foo.theme');
    $this->assertGeneratedFile('foo/logo.svg', '/_theme/logo.svg');
    $this->assertGeneratedFile('foo/package.json', '/_theme/package.json');
    $this->assertGeneratedFile('foo/theme-settings.php', '/_theme/theme-settings.php');
    $this->assertGeneratedFile('foo/config/install/foo.settings.yml', '/_theme/config/install/foo.settings.yml');
    $this->assertGeneratedFile('foo/config/schema/foo.schema.yml', '/_theme/config/schema/foo.schema.yml');
    $this->assertGeneratedFile('foo/js/foo.js', '/_theme/js/foo.js');
    $this->assertGeneratedFile('foo/scss/base/elements.scss', '/_theme/scss/base/elements.scss');
    $this->assertGeneratedFile('foo/scss/components/block.scss', '/_theme/scss/components/block.scss');
    $this->assertGeneratedFile('foo/scss/components/breadcrumb.scss', '/_theme/scss/components/breadcrumb.scss');
    $this->assertGeneratedFile('foo/scss/components/buttons.scss', '/_theme/scss/components/buttons.scss');
    $this->assertGeneratedFile('foo/scss/components/field.scss', '/_theme/scss/components/field.scss');
    $this->assertGeneratedFile('foo/scss/components/form.scss', '/_theme/scss/components/form.scss');
    $this->assertGeneratedFile('foo/scss/components/header.scss', '/_theme/scss/components/header.scss');
    $this->assertGeneratedFile('foo/scss/components/menu.scss', '/_theme/scss/components/menu.scss');
    $this->assertGeneratedFile('foo/scss/components/messages.scss', '/_theme/scss/components/messages.scss');
    $this->assertGeneratedFile('foo/scss/components/node.scss', '/_theme/scss/components/node.scss');
    $this->assertGeneratedFile('foo/scss/components/sidebar.scss', '/_theme/scss/components/sidebar.scss');
    $this->assertGeneratedFile('foo/scss/components/table.scss', '/_theme/scss/components/table.scss');
    $this->assertGeneratedFile('foo/scss/components/tabs.scss', '/_theme/scss/components/tabs.scss');
    $this->assertGeneratedFile('foo/scss/layouts/layout.scss', '/_theme/scss/layouts/layout.scss');
    $this->assertGeneratedFile('foo/scss/theme/print.scss', '/_theme/scss/theme/print.scss');
  }

}
