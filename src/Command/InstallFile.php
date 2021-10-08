<?php declare(strict_types=1);

namespace DrupalCodeGenerator\Command;

/**
 * Implements install-file command.
 */
final class InstallFile extends ModuleGenerator {

  protected string $name = 'install-file';
  protected string $description = 'Generates an install file';

  /**
   * {@inheritdoc}
   */
  protected function generate(array &$vars): void {
    $this->collectDefault($vars);
    $this->addFile('{machine_name}.install', 'install');
  }

}
