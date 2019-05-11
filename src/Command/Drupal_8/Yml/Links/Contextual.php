<?php

namespace DrupalCodeGenerator\Command\Drupal_8\Yml\Links;

use DrupalCodeGenerator\Command\ModuleGenerator;

/**
 * Implements d8:yml:links:contextual command.
 */
class Contextual extends ModuleGenerator {

  protected $name = 'd8:yml:links:contextual';
  protected $description = 'Generates links.contextual yml file';
  protected $alias = 'contextual-links';
  protected $nameQuestion = NULL;

  /**
   * {@inheritdoc}
   */
  protected function generate() :void {
    $this->collectDefault();
    $this->addFile('{machine_name}.links.contextual.yml', 'd8/yml/links.contextual');
  }

}
