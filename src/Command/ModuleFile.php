<?php declare(strict_types=1);

namespace DrupalCodeGenerator\Command;

use DrupalCodeGenerator\Application;

/**
 * Implements module-file command.
 */
final class ModuleFile extends ModuleGenerator {

  protected string $name = 'module-file';
  protected string $description = 'Generates a module file';
  protected string $templatePath = Application::TEMPLATE_PATH . '/module-file';

  /**
   * {@inheritdoc}
   */
  protected function generate(array &$vars): void {
    $this->collectDefault($vars);
    $this->addFile('{machine_name}.module', 'module');
  }

}
