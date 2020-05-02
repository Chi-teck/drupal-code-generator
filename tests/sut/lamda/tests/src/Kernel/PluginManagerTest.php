<?php

namespace Drupal\Tests\lamda\Kernel;

use Drupal\KernelTests\KernelTestBase;

/**
 * Plugin manager test.
 *
 * @group DCG
 */
final class PluginManagerTest extends KernelTestBase {

  /**
   * {@inheritdoc}
   */
  public static $modules = ['lamda'];

  /**
   * Test callback.
   */
  public function testPluginManagerAnnotation(): void {
    $plugin_manager = \Drupal::service('plugin.manager.alpha');

    $definition = $plugin_manager->getDefinition('foo');

    $this->assertEquals($definition['id'], 'foo');
    $this->assertEquals($definition['label'], 'Foo');
    $this->assertEquals($definition['description'], 'Foo description.');

    $plugin = $plugin_manager->createInstance('foo');
    $this->assertEquals($plugin->label(), 'Foo');
  }

  /**
   * Test callback.
   */
  public function testPluginManagerYaml(): void {
    $plugin_manager = \Drupal::service('plugin.manager.beta');
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

  /**
   * Test callback.
   */
  public function testPluginManagerHook(): void {
    $plugin_manager = \Drupal::service('plugin.manager.gamma');

    // Foo plugin.
    $definition = $plugin_manager->getDefinition('foo');

    $this->assertEquals($definition['id'], 'foo');
    $this->assertEquals($definition['label'], 'Foo');
    $this->assertEquals($definition['description'], 'Foo description.');

    $plugin = $plugin_manager->createInstance('foo');
    $this->assertEquals($plugin->label(), 'Foo');

    // Bar plugin.
    $definition = $plugin_manager->getDefinition('bar');

    $this->assertEquals($definition['id'], 'bar');
    $this->assertEquals($definition['label'], 'Bar');
    $this->assertEquals($definition['description'], 'Bar description.');

    $plugin = $plugin_manager->createInstance('bar');
    $this->assertEquals($plugin->label(), 'Bar');
  }

}
