<?php declare(strict_types=1);

namespace DrupalCodeGenerator\Tests\Generator;

/**
 * Test for layout command.
 */
final class LayoutTest extends BaseGeneratorTest {

  protected string $class = 'Layout';

  protected array $interaction = [
    'Module machine name [%default_machine_name%]:' => 'example',
    'Layout name [Example]:' => 'Foo bar',
    'Layout machine name [foo_bar]:' => 'foo_bar',
    'Category [My layouts]:' => 'My awesome layouts',
    'Would you like to create JavaScript file for this layout? [No]:' => 'Yes',
    'Would you like to create CSS file for this layout? [No]:' => 'Yes',
  ];

  protected array $fixtures = [
    'example.layouts.yml' => '/_layout/_layouts.yml',
    'example.libraries.yml' => '/_layout/_libraries.yml',
    'layouts/foo_bar/foo-bar.css' => '/_layout/_styles.css',
    'layouts/foo_bar/foo-bar.html.twig' => '/_layout/_template.html.twig',
    'layouts/foo_bar/foo-bar.js' => '/_layout/_javascript.js',
  ];

}
