<?php declare(strict_types = 1);

namespace Drupal\foo;

use Drupal\Core\Cache\CacheBackendInterface;
use Drupal\Core\Extension\ModuleHandlerInterface;
use Drupal\Core\Plugin\DefaultPluginManager;

/**
 * Bar plugin manager.
 */
final class BarPluginManager extends DefaultPluginManager {

  /**
   * Constructs BarPluginManager object.
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
