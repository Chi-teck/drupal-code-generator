<?php

namespace DrupalCodeGenerator\Tests\Generator\Drupal_8;

use DrupalCodeGenerator\Tests\Generator\GeneratorBaseTest;

/**
 * Test for d8:plugin-manager command (annotation discovery).
 */
class PluginManagerAnnotationTest extends GeneratorBaseTest {

  protected $class = 'Drupal_8\PluginManager';

  protected $interaction = [
    'Module name [%default_name%]:' => 'Foo',
    'Module machine name [foo]:' => 'foo',
    'Plugin type [foo]:' => 'bar',
    "Discovery type [Annotation]:\n  [1] Annotation\n  [2] YAML\n  [3] Hook" => 'Annotation',
  ];

  protected $fixtures = [
    'foo.services.yml' => __DIR__ . '/_plugin_manager_annotation/foo.services.yml',
    'src/BarInterface.php' => __DIR__ . '/_plugin_manager_annotation/src/BarInterface.php',
    'src/BarPluginBase.php' => __DIR__ . '/_plugin_manager_annotation/src/BarPluginBase.php',
    'src/BarPluginManager.php' => __DIR__ . '/_plugin_manager_annotation/src/BarPluginManager.php',
    'src/Annotation/Bar.php' => __DIR__ . '/_plugin_manager_annotation/src/Annotation/Bar.php',
    'src/Plugin/Bar/Foo.php' => __DIR__ . '/_plugin_manager_annotation/src/Plugin/Bar/Foo.php',
  ];

}
