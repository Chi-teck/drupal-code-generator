<?php

namespace Drupal\foo;

use Drupal\Core\Cache\CacheBackendInterface;
use Drupal\Core\Extension\ModuleHandlerInterface;
use Drupal\Core\Plugin\DefaultPluginManager;
use Drupal\Core\Plugin\Discovery\HookDiscovery;
use Drupal\Core\Plugin\Factory\ContainerFactory;

/**
 * Defines a plugin manager to deal with bars.
 *
 * @see \Drupal\foo\BarDefault
 * @see \Drupal\foo\BarInterface
 * @see plugin_api
 */
class BarPluginManager extends DefaultPluginManager {

  /**
   * {@inheritdoc}
   */
  protected $defaults = [
    // The bar id. Set by the plugin system based on the array key.
    'id' => '',
    // The bar label.
    'label' => '',
    // The bar description.
    'description' => '',
    // Default plugin class.
    'class' => 'Drupal\foo\BarDefault',
  ];

  /**
   * Constructs BarPluginManager object.
   *
   * @param \Drupal\Core\Extension\ModuleHandlerInterface $module_handler
   *   The module handler to invoke the alter hook with.
   * @param \Drupal\Core\Cache\CacheBackendInterface $cache_backend
   *   Cache backend instance to use.
   */
  public function __construct(ModuleHandlerInterface $module_handler, CacheBackendInterface $cache_backend) {
    $this->factory = new ContainerFactory($this);
    $this->moduleHandler = $module_handler;
    $this->alterInfo('bar_info');
    $this->setCacheBackend($cache_backend, 'bar_plugins');
  }

  /**
   * {@inheritdoc}
   */
  protected function getDiscovery() {
    if (!isset($this->discovery)) {
      $this->discovery = new HookDiscovery($this->moduleHandler, 'bar_info');
    }
    return $this->discovery;
  }

}
