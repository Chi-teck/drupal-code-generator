<?php declare(strict_types=1);

namespace DrupalCodeGenerator\Command\Misc\Drupal_7;

use DrupalCodeGenerator\Application;
use DrupalCodeGenerator\Command\ModuleGenerator;

/**
 * Implements misc:d7:install-file command.
 */
final class InstallFile extends ModuleGenerator {

  protected string $name = 'misc:d7:install-file';
  protected string $description = 'Generates Drupal 7 install file';
  protected string $templatePath = Application::TEMPLATE_PATH . '/misc/d7/install-file';

  /**
   * {@inheritdoc}
   */
  protected function generate(array &$vars): void {
    $this->collectDefault($vars);
    $this->addFile('{machine_name}.install', 'install');
  }

}
