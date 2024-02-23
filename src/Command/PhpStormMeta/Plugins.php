<?php

declare(strict_types=1);

namespace DrupalCodeGenerator\Command\PhpStormMeta;

use Drupal\Core\Plugin\DefaultPluginManager;
use DrupalCodeGenerator\Asset\File;
use DrupalCodeGenerator\Helper\Drupal\ServiceInfo;
use DrupalCodeGenerator\Utils;

/**
 * Generates PhpStorm meta-data for plugins.
 */
final class Plugins {

  /**
   * Constructs the object.
   */
  public function __construct(
    private readonly ServiceInfo $serviceInfo,
  ) {}

  /**
   * Generator callback.
   */
  public function __invoke(): File {
    $plugins = [];
    foreach ($this->serviceInfo->getServiceClasses() as $manager_id => $class) {
      /** @var class-string $class */
      if (!\is_subclass_of($class, DefaultPluginManager::class)) {
        continue;
      }
      /** @var \Drupal\Core\Plugin\DefaultPluginManager $manager */
      $manager = $this->serviceInfo->getService($manager_id);

      $guessed_interface = $class . 'Interface';
      $interface = $manager instanceof $guessed_interface
        ? $guessed_interface : NULL;

      $plugin_ids = \array_keys($manager->getDefinitions());
      \sort($plugin_ids);

      $plugins[] = [
        'manager_id' => $manager_id,
        'manager_class' => $class,
        'manager_interface' => $interface,
        'plugin_interface' => self::getPluginInterface($manager),
        'plugin_ids' => $plugin_ids,
      ];
    }

    return File::create('.phpstorm.meta.php/plugins.php')
      ->template('plugins.php.twig')
      ->vars(['plugins' => $plugins]);
  }

  /**
   * Getter for protected 'pluginInterface' property.
   */
  private static function getPluginInterface(DefaultPluginManager $manager): ?string {
    $interface = (new \ReflectionClass($manager))
      ->getProperty('pluginInterface')
      ->getValue($manager);
    return $interface ? Utils::addLeadingSlash($interface) : NULL;
  }

}
