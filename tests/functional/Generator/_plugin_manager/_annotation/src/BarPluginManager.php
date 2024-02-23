<?php

declare(strict_types=1);

namespace Drupal\foo;

use Drupal\Core\Cache\CacheBackendInterface;
use Drupal\Core\Extension\ModuleHandlerInterface;
use Drupal\Core\Plugin\DefaultPluginManager;
use Drupal\foo\Annotation\Bar;

/**
 * Bar plugin manager.
 */
final class BarPluginManager extends DefaultPluginManager {

  /**
   * Constructs the object.
   */
  public function __construct(\Traversable $namespaces, CacheBackendInterface $cache_backend, ModuleHandlerInterface $module_handler) {
    parent::__construct('Plugin/Bar', $namespaces, $module_handler, BarInterface::class, Bar::class);
    $this->alterInfo('bar_info');
    $this->setCacheBackend($cache_backend, 'bar_plugins');
  }

}
