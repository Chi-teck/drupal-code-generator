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
  ];

  protected $fixtures = [
    'foo/foo.breakpoints.yml' => __DIR__ . '/_theme/foo.breakpoints.yml',
    'foo/foo.info.yml' => __DIR__ . '/_theme/foo.info.yml',
    'foo/foo.libraries.yml' => __DIR__ . '/_theme/foo.libraries.yml',
    'foo/foo.theme' => __DIR__ . '/_theme/foo.theme',
    'foo/images' => [],
    'foo/logo.svg' => __DIR__ . '/_theme/logo.svg',
    'foo/templates' => [],
    'foo/theme-settings.php' => __DIR__ . '/_theme/theme-settings.php',
    'foo/config/install/foo.settings.yml' => __DIR__ . '/_theme/config/install/foo.settings.yml',
    'foo/config/schema/foo.schema.yml' => __DIR__ . '/_theme/config/schema/foo.schema.yml',
    'foo/css/base/elements.css' => __DIR__ . '/_theme/css/base/elements.css',
    'foo/css/components/block.css' => __DIR__ . '/_theme/css/components/block.css',
    'foo/css/components/breadcrumb.css' => __DIR__ . '/_theme/css/components/breadcrumb.css',
    'foo/css/components/buttons.css' => __DIR__ . '/_theme/css/components/buttons.css',
    'foo/css/components/field.css' => __DIR__ . '/_theme/css/components/field.css',
    'foo/css/components/form.css' => __DIR__ . '/_theme/css/components/form.css',
    'foo/css/components/header.css' => __DIR__ . '/_theme/css/components/header.css',
    'foo/css/components/menu.css' => __DIR__ . '/_theme/css/components/menu.css',
    'foo/css/components/messages.css' => __DIR__ . '/_theme/css/components/messages.css',
    'foo/css/components/node.css' => __DIR__ . '/_theme/css/components/node.css',
    'foo/css/components/sidebar.css' => __DIR__ . '/_theme/css/components/sidebar.css',
    'foo/css/components/table.css' => __DIR__ . '/_theme/css/components/table.css',
    'foo/css/components/tabs.css' => __DIR__ . '/_theme/css/components/tabs.css',
    'foo/css/layouts/layout.css' => __DIR__ . '/_theme/css/layouts/layout.css',
    'foo/css/theme/print.css' => __DIR__ . '/_theme/css/theme/print.css',
    'foo/js/foo.js' => __DIR__ . '/_theme/js/foo.js',
  ];

}
