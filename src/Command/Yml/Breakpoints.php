<?php declare(strict_types=1);

namespace DrupalCodeGenerator\Command\Yml;

use DrupalCodeGenerator\Application;
use DrupalCodeGenerator\Command\ThemeGenerator;

/**
 * Implements yml:breakpoints command.
 */
final class Breakpoints extends ThemeGenerator {

  protected string $name = 'yml:breakpoints';
  protected string $description = 'Generates a breakpoints yml file';
  protected string $alias = 'breakpoints';
  protected string $templatePath = Application::TEMPLATE_PATH . '/yml/breakpoints';
  protected ?string $nameQuestion = NULL;

  /**
   * {@inheritdoc}
   */
  protected function generate(array &$vars): void {
    $this->collectDefault($vars);
    $this->addFile('{machine_name}.breakpoints.yml', 'breakpoints');
  }

}
