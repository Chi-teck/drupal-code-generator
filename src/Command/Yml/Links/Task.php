<?php declare(strict_types=1);

namespace DrupalCodeGenerator\Command\Yml\Links;

use DrupalCodeGenerator\Application;
use DrupalCodeGenerator\Command\ModuleGenerator;

/**
 * Implements yml:links:task command.
 */
final class Task extends ModuleGenerator {

  protected string $name = 'yml:links:task';
  protected string $description = 'Generates a links.task yml file';
  protected string $alias = 'task-links';
  protected string $templatePath = Application::TEMPLATE_PATH . '/yml/links/task';
  protected ?string $nameQuestion = NULL;

  /**
   * {@inheritdoc}
   */
  protected function generate(array &$vars): void {
    $this->collectDefault($vars);
    $this->addFile('{machine_name}.links.task.yml', 'links.task');
  }

}
