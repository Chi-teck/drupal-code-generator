<?php

namespace DrupalCodeGenerator\Tests\Generator\Drupal_8\Plugin\Views;

use DrupalCodeGenerator\Tests\Generator\GeneratorBaseTest;

/**
 * Test for d8:plugin:views:style command.
 */
class StyleTest extends GeneratorBaseTest {

  protected $class = 'Drupal_8\Plugin\Views\Style';

  protected $interaction = [
    'Module name [%default_name%]:' => 'Example',
    'Module machine name [example]:' => 'example',
    'Plugin label [Example]:' => 'Foo',
    'Plugin ID [example_foo]:' => 'example_foo',
  ];

  protected $fixtures = [
    'example.module' => __DIR__ . '/_style.module',
    'templates/views-style-example-foo.html.twig' => __DIR__ . '/_style.twig',
    'config/schema/example.schema.yml' => __DIR__ . '/_style_schema.yml',
    'src/Plugin/views/style/Foo.php' => __DIR__ . '/_style.php',
  ];

}
