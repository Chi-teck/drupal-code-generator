<?php

namespace DrupalCodeGenerator\Command\Drupal_8;

use DrupalCodeGenerator\Command\ModuleGenerator;

/**
 * Implements d8:install-file command.
 */
class InstallFile extends ModuleGenerator {

  protected $name = 'd8:install-file';
  protected $description = 'Generates an install file';
  protected $alias = 'install-file';

  /**
   * {@inheritdoc}
   */
  protected function generate() :void {
    $this->collectDefault();
    $this->addFile('{machine_name}.install', 'd8/install');
  }

}
