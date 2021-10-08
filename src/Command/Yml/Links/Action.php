<?php declare(strict_types=1);

namespace DrupalCodeGenerator\Command\Yml\Links;

use DrupalCodeGenerator\Command\ModuleGenerator;

/**
 * Implements yml:links:action command.
 */
final class Action extends ModuleGenerator {

  protected $name = 'yml:links:action';
  protected $description = 'Generates a links.action yml file';
  protected $alias = 'action-links';
  protected $nameQuestion = NULL;

  /**
   * {@inheritdoc}
   */
  protected function generate(array &$vars): void {
    $this->collectDefault($vars);
    $this->addFile('{machine_name}.links.action.yml', 'links.action');
  }

}
