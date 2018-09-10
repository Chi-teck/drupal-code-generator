<?php

namespace Drupal\Tests\lamda\Kernel;

use Drupal\KernelTests\KernelTestBase;

/**
 * Test plugin manager (YAML discovery).
 *
 * @group DCG
 */
class PluginManagerTest extends KernelTestBase {

  /**
   * {@inheritdoc}
   */
  public static $modules = ['lamda_2'];

  /**
   * Test callback.
   */
  public function testPluginManager() {
    $plugin_manager = \Drupal::service('plugin.manager.bar');
    for ($i = 1; $i <= 3; $i++) {
      $plugin_id = 'foo_' . $i;
      $plugin_label = 'Foo ' . $i;
      $definition = $plugin_manager->getDefinition($plugin_id);

      $this->assertEquals($definition['id'], $plugin_id);
      $this->assertEquals($definition['label'], $plugin_label);
      $this->assertEquals($definition['description'], 'Plugin description.');

      $plugin = $plugin_manager->createInstance($plugin_id);
      $this->assertEquals($plugin->label(), $plugin_label);
    }
  }

}
