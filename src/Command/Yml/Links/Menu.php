<?php declare(strict_types=1);

namespace DrupalCodeGenerator\Command\Yml\Links;

use DrupalCodeGenerator\Application;
use DrupalCodeGenerator\Command\ModuleGenerator;

/**
 * Implements yml:links:menu command.
 */
final class Menu extends ModuleGenerator {

  protected string $name = 'yml:links:menu';
  protected string $description = 'Generates a links.menu yml file';
  protected string $alias = 'menu-links';
  protected string $templatePath = Application::TEMPLATE_PATH . '/yml/links/menu';
  protected ?string $nameQuestion = NULL;

  /**
   * {@inheritdoc}
   */
  protected function generate(array &$vars): void {
    $this->collectDefault($vars);
    $this->addFile('{machine_name}.links.menu.yml', 'links.menu');
  }

}
