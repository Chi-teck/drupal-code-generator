<?php

namespace DrupalCodeGenerator\Tests\Generator\Drupal_8;

use DrupalCodeGenerator\Tests\Generator\GeneratorBaseTest;

/**
 * Test for d8:plugin-manager command (hook discovery).
 */
class PluginManagerHookTest extends GeneratorBaseTest {

  protected $class = 'Drupal_8\PluginManager';

  protected $interaction = [
    'Module name [%default_name%]:' => 'Foo',
    'Module machine name [foo]:' => 'foo',
    'Plugin type [foo]:' => 'bar',
    "Discovery type [Annotation]:\n  [1] Annotation\n  [2] YAML\n  [3] Hook" => 'Hook',
  ];

  protected $fixtures = [
    'foo.module' => __DIR__ . '/_plugin_manager_hook/foo.module',
    'foo.services.yml' => __DIR__ . '/_plugin_manager_hook/foo.services.yml',
    'src/BarDefault.php' => __DIR__ . '/_plugin_manager_hook/src/BarDefault.php',
    'src/BarInterface.php' => __DIR__ . '/_plugin_manager_hook/src/BarInterface.php',
    'src/BarPluginManager.php' => __DIR__ . '/_plugin_manager_hook/src/BarPluginManager.php',
  ];

}
