<?php

namespace DrupalCodeGenerator\Command;

/**
 * Implements module-file command.
 */
final class ModuleFile extends ModuleGenerator {

  protected $name = 'module-file';
  protected $description = 'Generates a module file';

  /**
   * {@inheritdoc}
   */
  protected function generate(array &$vars): void {
    $this->collectDefault($vars);
    $this->addFile('{machine_name}.module', 'module');
  }

}
