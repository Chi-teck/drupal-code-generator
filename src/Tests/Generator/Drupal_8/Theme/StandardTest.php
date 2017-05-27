<?php

namespace DrupalCodeGenerator\Tests\Generator\Drupal_8\Theme;

use DrupalCodeGenerator\Tests\Generator\GeneratorTestCase;

/**
 * Test for d8:theme:standard command.
 */
class StandardTest extends GeneratorTestCase {

  protected $class = 'Drupal_8\Theme\Standard';

  protected $answers = [
    'Foo',
    'foo',
    'classy',
    'Description',
    'Custom',
    '8.x-1.0',
  ];

  protected $fixtures = [
    'foo/foo.info.yml' => NULL,
    'foo/foo.libraries.yml' => NULL,
    'foo/foo.theme' => NULL,
    'foo/js/foo.js' => NULL,
    'foo/templates' => NULL,
    'foo/images' => NULL,
    'foo/css/base/elements.css' => NULL,
    'foo/css/components/block.css' => NULL,
    'foo/css/components/breadcrumb.css' => NULL,
    'foo/css/components/field.css' => NULL,
    'foo/css/components/form.css' => NULL,
    'foo/css/components/header.css' => NULL,
    'foo/css/components/menu.css' => NULL,
    'foo/css/components/messages.css' => NULL,
    'foo/css/components/node.css' => NULL,
    'foo/css/components/sidebar.css' => NULL,
    'foo/css/components/table.css' => NULL,
    'foo/css/components/tabs.css' => NULL,
    'foo/css/components/buttons.css' => NULL,
    'foo/css/layouts/layout.css' => NULL,
    'foo/css/theme/print.css' => NULL,
  ];

}
