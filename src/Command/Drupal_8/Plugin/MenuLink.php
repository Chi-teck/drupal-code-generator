<?php

namespace DrupalCodeGenerator\Command\Drupal_8\Plugin;

/**
 * Implements d8:plugin:menu-link command.
 */
class MenuLink extends PluginGenerator {

  protected $name = 'd8:plugin:menu-link';
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
    $this->addFile('src/Plugin/Menu/{class}.php', 'd8/plugin/menu-link');
  }

}
