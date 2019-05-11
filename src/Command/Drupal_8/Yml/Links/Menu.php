<?php

namespace DrupalCodeGenerator\Command\Drupal_8\Yml\Links;

use DrupalCodeGenerator\Command\ModuleGenerator;

/**
 * Implements d8:yml:links:menu command.
 */
class Menu extends ModuleGenerator {

  protected $name = 'd8:yml:links:menu';
  protected $description = 'Generates a links.menu yml file';
  protected $alias = 'menu-links';
  protected $nameQuestion = NULL;

  /**
   * {@inheritdoc}
   */
  protected function generate() :void {
    $this->collectDefault();
    $this->addFile('{machine_name}.links.menu.yml', 'd8/yml/links.menu');
  }

}
