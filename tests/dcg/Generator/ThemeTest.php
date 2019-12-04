<?php

namespace DrupalCodeGenerator\Tests\Generator;

/**
 * Test for theme command.
 */
class ThemeTest extends BaseGeneratorTest {

  protected $fixtures = [
    'foo/css' => [],
    'foo/images' => [],
    'foo/templates/block' => [],
    'foo/templates/field' => [],
    'foo/templates/menu' => [],
    'foo/templates/node' => [],
    'foo/templates/page' => [],
    'foo/templates/view' => [],
    'foo/foo.breakpoints.yml' => '/_theme/foo.breakpoints.yml',
    'foo/foo.info.yml' => '/_theme/foo.info.yml',
    'foo/foo.libraries.yml' => '/_theme/foo.libraries.yml',
    'foo/foo.theme' => '/_theme/foo.theme',
    'foo/logo.svg' => '/_theme/logo.svg',
    'foo/package.json' => '/_theme/package.json',
    'foo/theme-settings.php' => '/_theme/theme-settings.php',
    'foo/config/install/foo.settings.yml' => '/_theme/config/install/foo.settings.yml',
    'foo/config/schema/foo.schema.yml' => '/_theme/config/schema/foo.schema.yml',
    'foo/js/foo.js' => '/_theme/js/foo.js',
    'foo/scss/base/elements.scss' => '/_theme/scss/base/elements.scss',
    'foo/scss/components/block.scss' => '/_theme/scss/components/block.scss',
    'foo/scss/components/breadcrumb.scss' => '/_theme/scss/components/breadcrumb.scss',
    'foo/scss/components/buttons.scss' => '/_theme/scss/components/buttons.scss',
    'foo/scss/components/field.scss' => '/_theme/scss/components/field.scss',
    'foo/scss/components/form.scss' => '/_theme/scss/components/form.scss',
    'foo/scss/components/header.scss' => '/_theme/scss/components/header.scss',
    'foo/scss/components/menu.scss' => '/_theme/scss/components/menu.scss',
    'foo/scss/components/messages.scss' => '/_theme/scss/components/messages.scss',
    'foo/scss/components/node.scss' => '/_theme/scss/components/node.scss',
    'foo/scss/components/sidebar.scss' => '/_theme/scss/components/sidebar.scss',
    'foo/scss/components/table.scss' => '/_theme/scss/components/table.scss',
    'foo/scss/components/tabs.scss' => '/_theme/scss/components/tabs.scss',
    'foo/scss/layouts/layout.scss' => '/_theme/scss/layouts/layout.scss',
    'foo/scss/theme/print.scss' => '/_theme/scss/theme/print.scss',
  ];

  protected $class = 'Theme';

  protected $interaction = [
    'Theme name [%default_name%]:' => 'Foo',
    'Theme machine name [foo]:' => 'foo',
    'Base theme [classy]:' => 'bartik',
    'Description [A flexible theme with a responsive, mobile-first layout.]:' => 'Some description.',
    'Package [Custom]:' => 'Custom',
    'Would you like to use SASS to compile style sheets? [No]:' => 'Yes',
    'Would you like to create breakpoints? [No]:' => 'Yes',
    'Would you like to create theme settings form? [No]:' => 'Yes',
  ];

}
