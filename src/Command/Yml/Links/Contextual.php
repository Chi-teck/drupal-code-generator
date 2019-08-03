<?php

namespace DrupalCodeGenerator\Command\Yml\Links;

use DrupalCodeGenerator\Command\ModuleGenerator;

/**
 * Implements yml:links:contextual command.
 */
final class Contextual extends ModuleGenerator {

  protected $name = 'yml:links:contextual';
  protected $description = 'Generates links.contextual yml file';
  protected $alias = 'contextual-links';
  protected $nameQuestion = NULL;

  /**
   * {@inheritdoc}
   */
  protected function generate(): void {
    $this->collectDefault();
    $this->addFile('{machine_name}.links.contextual.yml', 'links.contextual');
  }

}
