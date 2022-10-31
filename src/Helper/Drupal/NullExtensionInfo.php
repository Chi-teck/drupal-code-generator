<?php declare(strict_types = 1);

namespace DrupalCodeGenerator\Helper\Drupal;

use Drupal\Core\Extension\Extension;

/**
 * This helper can be used to avoid conditional calls for extension info.
 *
 * @todo Is it still needed?
 */
final class NullExtensionInfo implements ExtensionInfoInterface {

  /**
   * {@inheritdoc}
   */
  public function getExtensions(): array {
    return [];
  }

  /**
   * {@inheritdoc}
   */
  public function getDestination(string $machine_name, bool $is_new): ?string {
    return NULL;
  }

  /**
   * {@inheritdoc}
   */
  public function getExtensionName(string $machine_name): ?string {
    return NULL;
  }

  /**
   * {@inheritdoc}
   */
  public function getExtensionMachineName(string $name): ?string {
    return NULL;
  }

  /**
   * {@inheritDoc}
   */
  public function getExtensionFromPath(string $path): ?Extension {
    return NULL;
  }

}
