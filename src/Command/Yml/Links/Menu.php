<?php declare(strict_types=1);

namespace DrupalCodeGenerator\Command\Yml\Links;

use DrupalCodeGenerator\Command\ModuleGenerator;

/**
 * Implements yml:links:menu command.
 */
final class Menu extends ModuleGenerator {

  protected $name = 'yml:links:menu';
  protected $description = 'Generates a links.menu yml file';
  protected $alias = 'menu-links';
  protected $nameQuestion = NULL;

  /**
   * {@inheritdoc}
   */
  protected function generate(array &$vars): void {
    $this->collectDefault($vars);
    $this->addFile('{machine_name}.links.menu.yml', 'links.menu');
  }

}
