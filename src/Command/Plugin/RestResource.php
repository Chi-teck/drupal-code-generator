<?php

namespace DrupalCodeGenerator\Command\Plugin;

/**
 * Implements plugin:rest-resource command.
 */
final class RestResource extends PluginGenerator {

  protected $name = 'plugin:rest-resource';
  protected $description = 'Generates rest resource plugin';
  protected $alias = 'rest-resource';
  protected $label = 'REST resource';
  protected $pluginClassSuffix = 'Resource';

  /**
   * {@inheritdoc}
   */
  protected function generate(): void {
    $this->collectDefault();
    $this->addFile('src/Plugin/rest/resource/{class}.php', 'rest-resource');
  }

}
