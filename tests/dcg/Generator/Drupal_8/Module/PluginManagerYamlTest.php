<?php

namespace DrupalCodeGenerator\Tests\Generator\Drupal_8\Module;

use DrupalCodeGenerator\Tests\Generator\GeneratorBaseTest;

/**
 * Test for d8:module:plugin-manager command (YAML discovery).
 */
class PluginManagerYamlTest extends GeneratorBaseTest {

  protected $class = 'Drupal_8\Module\PluginManager';

  protected $interaction = [
    'Module name [%default_name%]:' => 'Foo',
    'Module machine name [foo]:' => 'foo',
    'Description [Module description.]:' => 'Foo description.',
    'Package [Custom]:' => 'Custom',
    'Dependencies (comma separated):' => 'drupal:views, drupal:field, drupal:node',
    'Plugin type [foo]:' => 'bar',
    "Discovery type [Annotation]:\n  [1] Annotation\n  [2] YAML\n  [3] Hook\n  ➤➤➤ " => 'YAML',
  ];

  protected $fixtures = [
    'foo/foo.bars.yml' => __DIR__ . '/_plugin_manager_yaml/foo.bars.yml',
    'foo/foo.info.yml' => __DIR__ . '/_plugin_manager_yaml/foo.info.yml',
    'foo/foo.services.yml' => __DIR__ . '/_plugin_manager_yaml/foo.services.yml',
    'foo/src/BarDefault.php' => __DIR__ . '/_plugin_manager_yaml/src/BarDefault.php',
    'foo/src/BarInterface.php' => __DIR__ . '/_plugin_manager_yaml/src/BarInterface.php',
    'foo/src/BarPluginManager.php' => __DIR__ . '/_plugin_manager_yaml/src/BarPluginManager.php',
  ];

  /**
   * {@inheritdoc}
   */
  protected function getExpectedDisplay() {
    $display = parent::getExpectedDisplay();
    return str_replace(" ➤➤➤ \n ➤ ", ' ➤➤➤ ', $display);
  }

}
