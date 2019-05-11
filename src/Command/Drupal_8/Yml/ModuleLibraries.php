<?php

namespace DrupalCodeGenerator\Command\Drupal_8\Yml;

use DrupalCodeGenerator\Command\ModuleGenerator;

/**
 * Implements d8:yml:module-libraries command.
 */
class ModuleLibraries extends ModuleGenerator {

  protected $name = 'd8:yml:module-libraries';
  protected $description = 'Generates module libraries yml file';
  protected $alias = 'module-libraries';
  protected $label = 'Libraries (module)';
  protected $nameQuestion = NULL;

  /**
   * {@inheritdoc}
   */
  protected function generate() :void {
    $this->collectDefault();
    $this->addFile('{machine_name}.libraries.yml', 'd8/yml/module-libraries');
  }

}
