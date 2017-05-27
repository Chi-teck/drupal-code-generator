<?php

namespace DrupalCodeGenerator\Tests\Generator\Drupal_8\Plugin\Style;

use DrupalCodeGenerator\Tests\Generator\GeneratorTestCase;

/**
 * Test for d8:plugin:views:style command.
 */
class StyleTest extends GeneratorTestCase {

  protected $class = 'Drupal_8\Plugin\Views\Style';

  protected $answers = [
    'Example',
    'example',
    'Foo',
    'example_foo',
  ];

  protected $fixtures = [
    'src/Plugin/views/style/Foo.php' => __DIR__ . '/_style.php',
    'templates/views-style-example-foo.html.twig' => __DIR__ . '/_style.twig',
    'example.module' => __DIR__ . '/_style.module',
  ];

}
