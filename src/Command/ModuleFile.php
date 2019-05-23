<?php

namespace DrupalCodeGenerator\Command;

/**
 * Implements module-file command.
 */
class ModuleFile extends ModuleGenerator {

  protected $name = 'module-file';
  protected $description = 'Generates a module file';

  /**
   * {@inheritdoc}
   */
  protected function generate() :void {
    $this->collectDefault();
    $this->addFile('{machine_name}.module', 'module');
  }

}
