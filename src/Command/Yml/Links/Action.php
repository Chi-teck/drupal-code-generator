<?php declare(strict_types=1);

namespace DrupalCodeGenerator\Command\Yml\Links;

use DrupalCodeGenerator\Application;
use DrupalCodeGenerator\Command\ModuleGenerator;

/**
 * Implements yml:links:action command.
 */
final class Action extends ModuleGenerator {

  protected string $name = 'yml:links:action';
  protected string $description = 'Generates a links.action yml file';
  protected string $alias = 'action-links';
  protected string $templatePath = Application::TEMPLATE_PATH . '/yml/links/action';
  protected ?string $nameQuestion = NULL;

  /**
   * {@inheritdoc}
   */
  protected function generate(array &$vars): void {
    $this->collectDefault($vars);
    $this->addFile('{machine_name}.links.action.yml', 'links.action');
  }

}
