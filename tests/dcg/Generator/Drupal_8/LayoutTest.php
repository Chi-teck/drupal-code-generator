<?php

namespace DrupalCodeGenerator\Tests\Generator\Drupal_8;

use DrupalCodeGenerator\Tests\Generator\GeneratorBaseTest;

/**
 * Test for d8:layout command.
 */
class LayoutTest extends GeneratorBaseTest {

  protected $class = 'Drupal_8\Layout';

  protected $interaction = [
    'Extension machine name [%default_machine_name%]:' => 'example',
    'Layout name [Example]:' => 'Foo bar',
    'Layout machine name [foo_bar]:' => 'foo_bar',
    'Category [My layouts]:' => 'My awesome layouts',
    'Would you like to create JavaScript file for this layout? [No]:' => 'Yes',
    'Would you like to create CSS file for this layout? [No]:' => 'Yes',
  ];

  protected $fixtures = [
    'example.layouts.yml' => __DIR__ . '/_layout/_layouts.yml',
    'example.libraries.yml' => __DIR__ . '/_layout/_libraries.yml',
    'layouts/foo_bar/foo-bar.css' => __DIR__ . '/_layout/_styles.css',
    'layouts/foo_bar/foo-bar.html.twig' => __DIR__ . '/_layout/_template.html.twig',
    'layouts/foo_bar/foo-bar.js' => __DIR__ . '/_layout/_javascript.js',
  ];

}
