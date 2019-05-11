<?php

namespace DrupalCodeGenerator\Command\Drupal_8;

use DrupalCodeGenerator\Command\ModuleGenerator;

/**
 * Implements d8:module-file command.
 */
class ModuleFile extends ModuleGenerator {

  protected $name = 'd8:module-file';
  protected $description = 'Generates a module file';
  protected $alias = 'module-file';

  /**
   * {@inheritdoc}
   */
  protected function generate() :void {
    $this->collectDefault();
    $this->addFile('{machine_name}.module', 'd8/module');
  }

}
