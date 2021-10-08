<?php declare(strict_types=1);

namespace DrupalCodeGenerator\Command;

/**
 * Implements module-file command.
 */
final class ModuleFile extends ModuleGenerator {

  protected string $name = 'module-file';
  protected string $description = 'Generates a module file';

  /**
   * {@inheritdoc}
   */
  protected function generate(array &$vars): void {
    $this->collectDefault($vars);
    $this->addFile('{machine_name}.module', 'module');
  }

}
