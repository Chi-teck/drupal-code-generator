<?php declare(strict_types=1);

namespace DrupalCodeGenerator\Command\Misc\Drupal_7;

use DrupalCodeGenerator\Application;
use DrupalCodeGenerator\Command\ModuleGenerator;

/**
 * Implements misc:d7:module-file command.
 */
final class ModuleFile extends ModuleGenerator {

  protected string $name = 'misc:d7:module-file';
  protected string $description = 'Generates Drupal 7 module file';
  protected string $templatePath = Application::TEMPLATE_PATH . '/misc/d7/module-file';

  /**
   * {@inheritdoc}
   */
  protected function generate(array &$vars): void {
    $this->collectDefault($vars);
    $this->addFile('{machine_name}.module', 'module');
  }

}
