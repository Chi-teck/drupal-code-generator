<?php

namespace Drupal\foo;

use Drupal\Core\Plugin\PluginBase;

/**
 * Default class used for bars plugins.
 */
class BarDefault extends PluginBase implements BarInterface {

  /**
   * {@inheritdoc}
   */
  public function label() {
    // The title from hook discovery may be a TranslatableMarkup object.
    return (string) $this->pluginDefinition['label'];
  }

}
