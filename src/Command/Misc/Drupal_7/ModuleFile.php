<?php

namespace DrupalCodeGenerator\Command\Misc\Drupal_7;

use DrupalCodeGenerator\Command\ModuleGenerator;

/**
 * Implements misc:d7:module-file command.
 */
final class ModuleFile extends ModuleGenerator {

  protected $name = 'misc:d7:module-file';
  protected $description = 'Generates Drupal 7 module file';

  /**
   * {@inheritdoc}
   */
  protected function generate() :void {
    $this->collectDefault();
    $this->addFile('{machine_name}.module', 'module');
  }

}
