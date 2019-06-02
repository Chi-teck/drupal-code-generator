<?php

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
  protected function generate() :void {
    $this->collectDefault();
    $this->addFile('{machine_name}.links.action.yml', 'yml/links.action');
  }

}
