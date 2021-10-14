<?php declare(strict_types=1);

namespace DrupalCodeGenerator\Command\Yml;

use DrupalCodeGenerator\Application;
use DrupalCodeGenerator\Command\ThemeGenerator;

/**
 * Implements yml:theme-libraries command.
 */
final class ThemeLibraries extends ThemeGenerator {

  protected string $name = 'yml:theme-libraries';
  protected string $description = 'Generates theme libraries yml file';
  protected string $alias = 'theme-libraries';
  protected string $label = 'Libraries (theme)';
  protected string $templatePath = Application::TEMPLATE_PATH . '/yml/theme-libraries';
  protected ?string $nameQuestion = NULL;

  /**
   * {@inheritdoc}
   */
  protected function generate(array &$vars): void {
    $this->collectDefault($vars);
    $this->addFile('{machine_name}.libraries.yml', 'theme-libraries');
  }

}
