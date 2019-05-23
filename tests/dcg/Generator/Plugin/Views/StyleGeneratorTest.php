<?php

namespace DrupalCodeGenerator\Tests\Generator\Plugin\Views;

use DrupalCodeGenerator\Tests\Generator\BaseGeneratorTest;

/**
 * Test for plugin:views:style command.
 */
class StyleGeneratorTest extends BaseGeneratorTest {

  protected $class = 'Plugin\Views\Style';

  protected $interaction = [
    'Module name [%default_name%]:' => 'Example',
    'Module machine name [example]:' => 'example',
    'Plugin label [Example]:' => 'Foo',
    'Plugin ID [example_foo]:' => 'example_foo',
    'Plugin class [Foo]:' => 'Foo',
    'Make the plugin configurable? [Yes]:' => 'Yes',
  ];

  protected $fixtures = [
    'example.module' => __DIR__ . '/_style.module',
    'templates/views-style-example-foo.html.twig' => __DIR__ . '/_style.twig',
    'config/schema/example.schema.yml' => __DIR__ . '/_style_schema.yml',
    'src/Plugin/views/style/Foo.php' => __DIR__ . '/_style.php',
  ];

}
