<?php declare(strict_types = 1);

namespace Drupal\foo;

use Drupal\Core\Plugin\PluginBase;

/**
 * Default class used for bars plugins.
 */
final class BarDefault extends PluginBase implements BarInterface {

  /**
   * {@inheritdoc}
   */
  public function label(): string {
    // The title from YAML file discovery may be a TranslatableMarkup object.
    return (string) $this->pluginDefinition['label'];
  }

}
