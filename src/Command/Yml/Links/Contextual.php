<?php declare(strict_types=1);

namespace DrupalCodeGenerator\Command\Yml\Links;

use DrupalCodeGenerator\Application;
use DrupalCodeGenerator\Command\ModuleGenerator;

/**
 * Implements yml:links:contextual command.
 */
final class Contextual extends ModuleGenerator {

  protected string $name = 'yml:links:contextual';
  protected string $description = 'Generates links.contextual yml file';
  protected string $alias = 'contextual-links';
  protected string $templatePath = Application::TEMPLATE_PATH . '/yml/links/contextual';
  protected ?string $nameQuestion = NULL;

  /**
   * {@inheritdoc}
   */
  protected function generate(array &$vars): void {
    $this->collectDefault($vars);
    $this->addFile('{machine_name}.links.contextual.yml', 'links.contextual');
  }

}
