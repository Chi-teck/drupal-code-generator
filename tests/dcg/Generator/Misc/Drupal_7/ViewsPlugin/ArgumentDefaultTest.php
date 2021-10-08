<?php declare(strict_types=1);

namespace DrupalCodeGenerator\Tests\Generator\Misc\Drupal_7\ViewsPlugin;

use DrupalCodeGenerator\Tests\Generator\BaseGeneratorTest;

/**
 * Test for misc:d7:views-plugin:argument-default command.
 */
final class ArgumentDefaultTest extends BaseGeneratorTest {

  protected string $class = 'Misc\Drupal_7\ViewsPlugin\ArgumentDefault';

  protected array $interaction = [
    'Module name [%default_name%]:' => 'Example',
    'Module machine name [example]:' => 'example',
    'Plugin name [Example]:' => 'Foo',
    'Plugin machine name [foo]:' => 'foo',
  ];

  protected array $fixtures = [
    'example.module' => '/_argument_default.module',
    'views/example.views.inc' => '/_argument_default_views.inc',
    'views/views_plugin_argument_foo.inc' => '/_argument_default.inc',
  ];

}
