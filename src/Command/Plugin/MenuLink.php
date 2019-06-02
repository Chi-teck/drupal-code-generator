<?php

namespace DrupalCodeGenerator\Command\Plugin;

/**
 * Implements plugin:menu-link command.
 */
final class MenuLink extends PluginGenerator {

  protected $name = 'plugin:menu-link';
  protected $description = 'Generates menu-link plugin';
  protected $alias = 'menu-link';
  protected $pluginLabelQuestion = FALSE;
  protected $pluginIdQuestion = FALSE;
  protected $pluginClassQuestion = 'Class';
  protected $pluginClassDefault = '{machine_name|camelize}MenuLink';

  /**
   * {@inheritdoc}
   */
  protected function generate() :void {
    $this->collectDefault();
    $this->addFile('src/Plugin/Menu/{class}.php', 'plugin/menu-link');
  }

}
