<?php

namespace DrupalCodeGenerator\Command;

/**
 * Implements install-file command.
 */
class InstallFile extends ModuleGenerator {

  protected $name = 'install-file';
  protected $description = 'Generates an install file';

  /**
   * {@inheritdoc}
   */
  protected function generate() :void {
    $this->collectDefault();
    $this->addFile('{machine_name}.install', 'install');
  }

}
