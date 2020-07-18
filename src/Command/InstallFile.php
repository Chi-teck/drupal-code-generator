<?php

namespace DrupalCodeGenerator\Command;

/**
 * Implements install-file command.
 */
final class InstallFile extends ModuleGenerator {

  protected $name = 'install-file';
  protected $description = 'Generates an install file';

  /**
   * {@inheritdoc}
   */
  protected function generate(array &$vars): void {
    $this->collectDefault($vars);
    $this->addFile('{machine_name}.install', 'install');
  }

}
