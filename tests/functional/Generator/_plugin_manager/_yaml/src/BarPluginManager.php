<?php declare(strict_types = 1);

namespace Drupal\foo;

use Drupal\Core\Cache\CacheBackendInterface;
use Drupal\Core\Extension\ModuleHandlerInterface;
use Drupal\Core\Plugin\DefaultPluginManager;
use Drupal\Core\Plugin\Discovery\YamlDiscovery;
use Drupal\Core\Plugin\Factory\ContainerFactory;

/**
 * Defines a plugin manager to deal with bars.
 *
 * Modules can define bars in a MODULE_NAME.bars.yml file contained
 * in the module's base directory. Each bar has the following structure:
 *
 * @code
 *   MACHINE_NAME:
 *     label: STRING
 *     description: STRING
 * @endcode
 *
 * @see \Drupal\foo\BarDefault
 * @see \Drupal\foo\BarInterface
 */
final class BarPluginManager extends DefaultPluginManager {

  /**
   * {@inheritdoc}
   */
  protected $defaults = [
    // The bar id. Set by the plugin system based on the top-level YAML key.
    'id' => '',
    // The bar label.
    'label' => '',
    // The bar description.
    'description' => '',
    // Default plugin class.
    'class' => BarDefault::class,
  ];

  /**
   * Constructs BarPluginManager object.
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
  protected function getDiscovery(): YamlDiscovery {
    if (!isset($this->discovery)) {
      $this->discovery = new YamlDiscovery('bars', $this->moduleHandler->getModuleDirectories());
      $this->discovery->addTranslatableProperty('label', 'label_context');
      $this->discovery->addTranslatableProperty('description', 'description_context');
    }
    return $this->discovery;
  }

}
