<?php

namespace DrupalCodeGenerator\Tests\Generator\Drupal_8\Theme;

use DrupalCodeGenerator\Tests\Generator\GeneratorBaseTest;

/**
 * Test for d8:theme:standard command.
 */
class StandardTest extends GeneratorBaseTest {

  protected $class = 'Drupal_8\Theme\Standard';

  protected $interaction = [
    'Theme name [%default_name%]: ' => 'Foo',
    'Theme machine name [foo]: ' => 'foo',
    'Base theme [classy]: ' => 'Bartik',
    'Description [A flexible theme with a responsive, mobile-first layout.]: ' => 'Some description.',
    'Package [Custom]: ' => 'Custom',
  ];

  protected $fixtures = [
    'foo/foo.breakpoints.yml' => NULL,
    'foo/foo.info.yml' => NULL,
    'foo/foo.libraries.yml' => NULL,
    'foo/foo.theme' => NULL,
    'foo/images' => NULL,
    'foo/logo.svg' => NULL,
    'foo/templates' => NULL,
    'foo/config/schema/foo.schema.yml' => NULL,
    'foo/css/base/elements.css' => NULL,
    'foo/css/components/block.css' => NULL,
    'foo/css/components/breadcrumb.css' => NULL,
    'foo/css/components/buttons.css' => NULL,
    'foo/css/components/field.css' => NULL,
    'foo/css/components/form.css' => NULL,
    'foo/css/components/header.css' => NULL,
    'foo/css/components/menu.css' => NULL,
    'foo/css/components/messages.css' => NULL,
    'foo/css/components/node.css' => NULL,
    'foo/css/components/sidebar.css' => NULL,
    'foo/css/components/table.css' => NULL,
    'foo/css/components/tabs.css' => NULL,
    'foo/css/layouts/layout.css' => NULL,
    'foo/css/theme/print.css' => NULL,
    'foo/js/foo.js' => NULL,
  ];

}
