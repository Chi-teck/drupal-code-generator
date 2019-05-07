<?php

namespace DrupalCodeGenerator\Command\Drupal_7;

use DrupalCodeGenerator\Command\ModuleGenerator;

/**
 * Implements d7:install-file command.
 */
class InstallFile extends ModuleGenerator {

  protected $name = 'd7:install-file';
  protected $description = 'Generates Drupal 7 install file';

  /**
   * {@inheritdoc}
   */
  protected function generate() :void {
    $this->collectDefault();
    $this->addFile('{machine_name}.install', 'd7/install');
  }

}
