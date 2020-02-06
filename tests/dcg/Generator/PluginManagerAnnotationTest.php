<?php

namespace DrupalCodeGenerator\Tests\Generator;

/**
 * Test for plugin-manager command (annotation discovery).
 */
final class PluginManagerAnnotationTest extends BaseGeneratorTest {

  protected $class = 'PluginManager';

  protected $interaction = [
    'Module name [%default_name%]:' => 'Foo',
    'Module machine name [foo]:' => 'foo',
    'Plugin type [foo]:' => 'bar',
    "Discovery type [Annotation]:\n  [1] Annotation\n  [2] YAML\n  [3] Hook" => 'Annotation',
  ];

  protected $fixtures = [
    'foo.services.yml' => '/_plugin_manager_annotation/foo.services.yml',
    'src/BarInterface.php' => '/_plugin_manager_annotation/src/BarInterface.php',
    'src/BarPluginBase.php' => '/_plugin_manager_annotation/src/BarPluginBase.php',
    'src/BarPluginManager.php' => '/_plugin_manager_annotation/src/BarPluginManager.php',
    'src/Annotation/Bar.php' => '/_plugin_manager_annotation/src/Annotation/Bar.php',
    'src/Plugin/Bar/Foo.php' => '/_plugin_manager_annotation/src/Plugin/Bar/Foo.php',
  ];

}
