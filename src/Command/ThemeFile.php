<?php declare(strict_types=1);

namespace DrupalCodeGenerator\Command;

use DrupalCodeGenerator\Application;

/**
 * Implements theme-file command.
 */
final class ThemeFile extends ThemeGenerator {

  protected string $name = 'theme-file';
  protected string $description = 'Generates a theme file';
  protected string $templatePath = Application::TEMPLATE_PATH . '/theme-file';

  /**
   * {@inheritdoc}
   */
  protected function generate(array &$vars): void {
    $this->collectDefault($vars);
    $this->addFile('{machine_name}.theme', 'theme');
  }

}
