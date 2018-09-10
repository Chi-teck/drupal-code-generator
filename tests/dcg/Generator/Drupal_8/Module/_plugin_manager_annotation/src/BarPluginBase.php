<?php

namespace Drupal\foo;

use Drupal\Component\Plugin\PluginBase;

/**
 * Base class for bar plugins.
 */
abstract class BarPluginBase extends PluginBase implements BarInterface {

  /**
   * {@inheritdoc}
   */
  public function label() {
    // Cast the label to a string since it is a TranslatableMarkup object.
    return (string) $this->pluginDefinition['label'];
  }

}
