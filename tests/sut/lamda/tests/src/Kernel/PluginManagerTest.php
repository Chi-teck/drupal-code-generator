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
  protected static $modules = ['lamda'];

  /**
   * Test callback.
   */
  public function testPluginManagerAnnotation(): void {
    $plugin_manager = \Drupal::service('plugin.manager.alpha');

    $definition = $plugin_manager->getDefinition('foo');

    self::assertEquals($definition['id'], 'foo');
    self::assertEquals($definition['label'], 'Foo');
    self::assertEquals($definition['description'], 'Foo description.');

    $plugin = $plugin_manager->createInstance('foo');
    self::assertEquals($plugin->label(), 'Foo');
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

      self::assertEquals($definition['id'], $plugin_id);
      self::assertEquals($definition['label'], $plugin_label);
      self::assertEquals($definition['description'], 'Plugin description.');

      $plugin = $plugin_manager->createInstance($plugin_id);
      self::assertEquals($plugin->label(), $plugin_label);
    }
  }

  /**
   * Test callback.
   */
  public function testPluginManagerHook(): void {
    $plugin_manager = \Drupal::service('plugin.manager.gamma');

    // Foo plugin.
    $definition = $plugin_manager->getDefinition('foo');

    self::assertEquals($definition['id'], 'foo');
    self::assertEquals($definition['label'], 'Foo');
    self::assertEquals($definition['description'], 'Foo description.');

    $plugin = $plugin_manager->createInstance('foo');
    self::assertEquals($plugin->label(), 'Foo');

    // Bar plugin.
    $definition = $plugin_manager->getDefinition('bar');

    self::assertEquals($definition['id'], 'bar');
    self::assertEquals($definition['label'], 'Bar');
    self::assertEquals($definition['description'], 'Bar description.');

    $plugin = $plugin_manager->createInstance('bar');
    self::assertEquals($plugin->label(), 'Bar');
  }

}
