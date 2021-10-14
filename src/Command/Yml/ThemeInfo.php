<?php declare(strict_types=1);

namespace DrupalCodeGenerator\Command\Yml;

use DrupalCodeGenerator\Application;
use DrupalCodeGenerator\Command\ThemeGenerator;

/**
 * Implements yml:theme-info command.
 */
final class ThemeInfo extends ThemeGenerator {

  protected string $name = 'yml:theme-info';
  protected string $description = 'Generates a theme info yml file';
  protected string $alias = 'theme-info';
  protected string $label = 'Info (theme)';
  protected string $templatePath = Application::TEMPLATE_PATH . '/yml/theme-info';

  /**
   * {@inheritdoc}
   */
  protected function generate(array &$vars): void {
    $this->collectDefault($vars);
    $vars['base_theme'] = $this->ask('Base theme', 'classy', '::validateRequiredMachineName');
    $vars['description'] = $this->ask('Description', 'A flexible theme with a responsive, mobile-first layout.', '::validateRequired');
    $vars['package'] = $this->ask('Package', 'Custom');
    $this->addFile('{machine_name}.info.yml', 'theme-info');
  }

}
