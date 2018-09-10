<?php

namespace Drupal\Tests\lamda\Kernel;

use Drupal\KernelTests\KernelTestBase;

/**
 * Test plugin manager (annotation discovery).
 *
 * @group DCG
 */
class PluginManagerTest extends KernelTestBase {

  /**
   * {@inheritdoc}
   */
  public static $modules = ['lamda_1'];

  /**
   * Test callback.
   */
  public function testPluginManager() {
    $plugin_manager = \Drupal::service('plugin.manager.bar');

    $definition = $plugin_manager->getDefinition('foo');

    $this->assertEquals($definition['id'], 'foo');
    $this->assertEquals($definition['label'], 'Foo');
    $this->assertEquals($definition['description'], 'Foo description.');

    $plugin = $plugin_manager->createInstance('foo');
    $this->assertEquals($plugin->label(), 'Foo');
  }

}
