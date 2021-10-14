<?php declare(strict_types=1);

namespace DrupalCodeGenerator\Command\Service;

use DrupalCodeGenerator\Application;
use DrupalCodeGenerator\Command\ModuleGenerator;

/**
 * Implements service:uninstall-validator command.
 */
final class UninstallValidator extends ModuleGenerator {

  protected string $name = 'service:uninstall-validator';
  protected string $description = 'Generates a uninstall validator service';
  protected string $alias = 'uninstall-validator';
  protected string $templatePath = Application::TEMPLATE_PATH . '/service/uninstall-validator';

  /**
   * {@inheritdoc}
   */
  protected function generate(array &$vars): void {
    $this->collectDefault($vars);
    $vars['class'] = $this->ask('Class', '{name|camelize}UninstallValidator');
    $this->addFile('src/{class}.php', 'uninstall-validator');
    $this->addServicesFile()->template('services');
  }

}
