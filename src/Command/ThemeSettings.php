<?php declare(strict_types=1);

namespace DrupalCodeGenerator\Command;

use DrupalCodeGenerator\Application;

/**
 * Implements theme-settings command.
 */
final class ThemeSettings extends ThemeGenerator {

  protected string $name = 'theme-settings';
  protected string $description = 'Generates Drupal theme-settings.php file';
  protected string $templatePath = Application::TEMPLATE_PATH . '/theme-settings';

  /**
   * {@inheritdoc}
   */
  protected function generate(array &$vars): void {
    $this->collectDefault($vars);
    $this->addFile('theme-settings.php', 'form');
    $this->addFile('config/install/{machine_name}.settings.yml', 'config');
    $this->addFile('config/schema/{machine_name}.schema.yml', 'schema');
  }

}
