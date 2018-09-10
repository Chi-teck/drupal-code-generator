<?php

namespace DrupalCodeGenerator\Tests\Generator\Drupal_8\Module;

use DrupalCodeGenerator\Tests\Generator\GeneratorBaseTest;

/**
 * Test for d8:module:plugin-manager command (annotation discovery).
 */
class PluginManagerAnnotationTest extends GeneratorBaseTest {

  protected $class = 'Drupal_8\Module\PluginManager';

  protected $interaction = [
    'Module name [%default_name%]:' => 'Foo',
    'Module machine name [foo]:' => 'foo',
    'Package [Custom]:' => 'Custom',
    'Dependencies (comma separated):' => 'drupal:views, drupal:field, drupal:node',
    'Plugin type [foo]:' => 'bar',
    "Discovery type [Annotation]:\n  [1] Annotation\n  [2] YAML\n  [3] Hook\n  ➤➤➤ " => 'Annotation',
  ];

  protected $fixtures = [
    'foo/foo.info.yml' => __DIR__ . '/_plugin_manager_annotation/foo.info.yml',
    'foo/foo.services.yml' => __DIR__ . '/_plugin_manager_annotation/foo.services.yml',
    'foo/src/Annotation/Bar.php' => __DIR__ . '/_plugin_manager_annotation/src/Annotation/Bar.php',
    'foo/src/BarInterface.php' => __DIR__ . '/_plugin_manager_annotation/src/BarInterface.php',
    'foo/src/BarPluginBase.php' => __DIR__ . '/_plugin_manager_annotation/src/BarPluginBase.php',
    'foo/src/BarPluginManager.php' => __DIR__ . '/_plugin_manager_annotation/src/BarPluginManager.php',
    'foo/src/Plugin/Bar/Foo.php' => __DIR__ . '/_plugin_manager_annotation/src/Plugin/Bar/Foo.php',
  ];

  /**
   * {@inheritdoc}
   */
  protected function getExpectedDisplay() {
    $display = parent::getExpectedDisplay();
    return str_replace(" ➤➤➤ \n ➤ ", ' ➤➤➤ ', $display);
  }

}
