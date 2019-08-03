<?php

namespace DrupalCodeGenerator\Command\Misc\Drupal_7;

use DrupalCodeGenerator\Command\ModuleGenerator;

/**
 * Implements misc:d7:install-file command.
 */
final class InstallFile extends ModuleGenerator {

  protected $name = 'misc:d7:install-file';
  protected $description = 'Generates Drupal 7 install file';

  /**
   * {@inheritdoc}
   */
  protected function generate(): void {
    $this->collectDefault();
    $this->addFile('{machine_name}.install', 'install');
  }

}
