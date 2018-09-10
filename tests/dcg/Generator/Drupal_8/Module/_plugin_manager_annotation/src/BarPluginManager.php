<?php

namespace Drupal\foo;

use Drupal\Core\Cache\CacheBackendInterface;
use Drupal\Core\Extension\ModuleHandlerInterface;
use Drupal\Core\Plugin\DefaultPluginManager;

/**
 * Bar plugin manager.
 */
class BarPluginManager extends DefaultPluginManager {

  /**
   * Constructs BarPluginManager object.
   *
   * @param \Traversable $namespaces
   *   An object that implements \Traversable which contains the root paths
   *   keyed by the corresponding namespace to look for plugin implementations.
   * @param \Drupal\Core\Cache\CacheBackendInterface $cache_backend
   *   Cache backend instance to use.
   * @param \Drupal\Core\Extension\ModuleHandlerInterface $module_handler
   *   The module handler to invoke the alter hook with.
   */
  public function __construct(\Traversable $namespaces, CacheBackendInterface $cache_backend, ModuleHandlerInterface $module_handler) {
    parent::__construct(
      'Plugin/Bar',
      $namespaces,
      $module_handler,
      'Drupal\foo\BarInterface',
      'Drupal\foo\Annotation\Bar'
    );
    $this->alterInfo('bar_info');
    $this->setCacheBackend($cache_backend, 'bar_plugins');
  }

}
