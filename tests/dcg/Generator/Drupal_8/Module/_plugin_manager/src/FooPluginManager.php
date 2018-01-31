<?php

namespace Drupal\foo;

use Drupal\Core\Cache\CacheBackendInterface;
use Drupal\Core\Extension\ModuleHandlerInterface;
use Drupal\Core\Plugin\DefaultPluginManager;

/**
 * Foo plugin manager.
 */
class FooPluginManager extends DefaultPluginManager {

  /**
   * Constructs FooPluginManager object.
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
      'Plugin/Foo',
      $namespaces,
      $module_handler,
      'Drupal\foo\FooInterface',
      'Drupal\foo\Annotation\Foo'
    );
    $this->alterInfo('foo_info');
    $this->setCacheBackend($cache_backend, 'foo_info');
  }

}
