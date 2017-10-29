<?php

namespace Drupal\Tests\lamda\Kernel;

use Drupal\KernelTests\KernelTestBase;

/**
 * Test plugin manager.
 *
 * @group DCG
 */
class PluginManagerTest extends KernelTestBase {

  /**
   * {@inheritdoc}
   */
  public static $modules = ['lamda'];

  /**
   * Test callback.
   */
  public function testBlockRendering() {
    $plugin_manager = \Drupal::service('plugin.manager.lamda');

    $definition = $plugin_manager->getDefinition('example');

    $this->assertEquals($definition['id'], 'example');
    $this->assertEquals($definition['label'], 'Example');
    $this->assertEquals($definition['description'], 'Example description.');

    /** @var \Drupal\lamda\Plugin\Lamda\Example $lamda */
    $lamda = $plugin_manager->createInstance($definition['id']);

    $this->assertEquals($lamda->method1(), 'Drupal\lamda\Plugin\Lamda\Example implementation of method1');
    $this->assertEquals($lamda->method2(), 'default implementation of method2');
    $this->assertEquals($lamda->method3(), 'default implementation of method3');
  }

}
