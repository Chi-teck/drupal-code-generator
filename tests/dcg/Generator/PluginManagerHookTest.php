<?php declare(strict_types=1);

namespace DrupalCodeGenerator\Tests\Generator;

/**
 * Test for plugin-manager command (hook discovery).
 */
final class PluginManagerHookTest extends BaseGeneratorTest {

  protected string $class = 'PluginManager';

  protected array $interaction = [
    'Module name [%default_name%]:' => 'Foo',
    'Module machine name [foo]:' => 'foo',
    'Plugin type [foo]:' => 'bar',
    "Discovery type [Annotation]:\n  [1] Annotation\n  [2] YAML\n  [3] Hook" => 'Hook',
  ];

  protected array $fixtures = [
    'foo.module' => '/_plugin_manager_hook/foo.module',
    'foo.services.yml' => '/_plugin_manager_hook/foo.services.yml',
    'src/BarDefault.php' => '/_plugin_manager_hook/src/BarDefault.php',
    'src/BarInterface.php' => '/_plugin_manager_hook/src/BarInterface.php',
    'src/BarPluginManager.php' => '/_plugin_manager_hook/src/BarPluginManager.php',
  ];

}
