<?php

namespace DrupalCodeGenerator\Tests\Generator\Drupal_8;

use DrupalCodeGenerator\Tests\Generator\GeneratorBaseTest;

/**
 * Test for d8:theme command.
 */
class ThemeTest extends GeneratorBaseTest {

  protected $class = 'Drupal_8\Theme';

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

  protected $fixtures = [
    'foo/css' => [],
    'foo/foo.breakpoints.yml' => __DIR__ . '/_theme/foo.breakpoints.yml',
    'foo/foo.info.yml' => __DIR__ . '/_theme/foo.info.yml',
    'foo/foo.libraries.yml' => __DIR__ . '/_theme/foo.libraries.yml',
    'foo/foo.theme' => __DIR__ . '/_theme/foo.theme',
    'foo/images' => [],
    'foo/logo.svg' => __DIR__ . '/_theme/logo.svg',
    'foo/package.json' => __DIR__ . '/_theme/package.json',
    'foo/theme-settings.php' => __DIR__ . '/_theme/theme-settings.php',
    'foo/config/install/foo.settings.yml' => __DIR__ . '/_theme/config/install/foo.settings.yml',
    'foo/config/schema/foo.schema.yml' => __DIR__ . '/_theme/config/schema/foo.schema.yml',
    'foo/js/foo.js' => __DIR__ . '/_theme/js/foo.js',
    'foo/scss/base/elements.scss' => __DIR__ . '/_theme/scss/base/elements.scss',
    'foo/scss/components/block.scss' => __DIR__ . '/_theme/scss/components/block.scss',
    'foo/scss/components/breadcrumb.scss' => __DIR__ . '/_theme/scss/components/breadcrumb.scss',
    'foo/scss/components/buttons.scss' => __DIR__ . '/_theme/scss/components/buttons.scss',
    'foo/scss/components/field.scss' => __DIR__ . '/_theme/scss/components/field.scss',
    'foo/scss/components/form.scss' => __DIR__ . '/_theme/scss/components/form.scss',
    'foo/scss/components/header.scss' => __DIR__ . '/_theme/scss/components/header.scss',
    'foo/scss/components/menu.scss' => __DIR__ . '/_theme/scss/components/menu.scss',
    'foo/scss/components/messages.scss' => __DIR__ . '/_theme/scss/components/messages.scss',
    'foo/scss/components/node.scss' => __DIR__ . '/_theme/scss/components/node.scss',
    'foo/scss/components/sidebar.scss' => __DIR__ . '/_theme/scss/components/sidebar.scss',
    'foo/scss/components/table.scss' => __DIR__ . '/_theme/scss/components/table.scss',
    'foo/scss/components/tabs.scss' => __DIR__ . '/_theme/scss/components/tabs.scss',
    'foo/scss/layouts/layout.scss' => __DIR__ . '/_theme/scss/layouts/layout.scss',
    'foo/scss/theme/print.scss' => __DIR__ . '/_theme/scss/theme/print.scss',
    'foo/templates/block' => [],
    'foo/templates/field' => [],
    'foo/templates/menu' => [],
    'foo/templates/node' => [],
    'foo/templates/page' => [],
    'foo/templates/view' => [],
  ];

}
