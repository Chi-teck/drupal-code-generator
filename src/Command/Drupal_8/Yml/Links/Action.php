<?php

namespace DrupalCodeGenerator\Command\Drupal_8\Yml\Links;

use DrupalCodeGenerator\Command\ModuleGenerator;

/**
 * Implements d8:yml:links:action command.
 */
class Action extends ModuleGenerator {

  protected $name = 'd8:yml:links:action';
  protected $description = 'Generates a links.action yml file';
  protected $alias = 'action-links';
  protected $nameQuestion = NULL;

  /**
   * {@inheritdoc}
   */
  protected function generate() :void {
    $this->collectDefault();
    $this->addFile('{machine_name}.links.action.yml', 'd8/yml/links.action');
  }

}
