<?php declare(strict_types=1);

namespace DrupalCodeGenerator\Tests\Generator\Plugin\Views;

use DrupalCodeGenerator\Tests\Generator\BaseGeneratorTest;

/**
 * Test for plugin:views:style command.
 */
final class StyleTest extends BaseGeneratorTest {

  protected string $class = 'Plugin\Views\Style';

  protected array $interaction = [
    'Module name [%default_name%]:' => 'Example',
    'Module machine name [example]:' => 'example',
    'Plugin label [Example]:' => 'Foo',
    'Plugin ID [example_foo]:' => 'example_foo',
    'Plugin class [Foo]:' => 'Foo',
    'Make the plugin configurable? [Yes]:' => 'Yes',
  ];

  protected array $fixtures = [
    'example.module' => '/_style.module',
    'config/schema/example.schema.yml' => '/_style_schema.yml',
    'src/Plugin/views/style/Foo.php' => '/_style.php',
    'templates/views-style-example-foo.html.twig' => '/_style.twig',
  ];

}
