<?php

namespace DrupalCodeGenerator\Command\Drupal_8\Plugin;

use DrupalCodeGenerator\Command\ModuleGenerator;

/**
 * Implements d8:plugin:menu-link command.
 */
class MenuLink extends ModuleGenerator {

  protected $name = 'd8:plugin:menu-link';
  protected $description = 'Generates menu-link plugin';
  protected $alias = 'menu-link';

  /**
   * {@inheritdoc}
   */
  protected function generate() :void {
    $vars = &$this->collectDefault();
    $vars['class'] = $this->ask('Class', '{machine_name|camelize}MenuLink');
    $this->addFile('src/Plugin/Menu/{class}.php', 'd8/plugin/menu-link');
  }

}
