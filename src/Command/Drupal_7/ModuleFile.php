<?php

namespace DrupalCodeGenerator\Command\Drupal_7;

use DrupalCodeGenerator\Command\ModuleGenerator;

/**
 * Implements d7:module-file command.
 */
class ModuleFile extends ModuleGenerator {

  protected $name = 'd7:module-file';
  protected $description = 'Generates Drupal 7 module file';

  /**
   * {@inheritdoc}
   */
  protected function generate() :void {
    $this->collectDefault();
    $this->addFile('{machine_name}.module', 'd7/module');
  }

}
