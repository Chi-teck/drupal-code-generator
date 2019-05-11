<?php

namespace DrupalCodeGenerator\Command\Drupal_8\Yml\Links;

use DrupalCodeGenerator\Command\ModuleGenerator;

/**
 * Implements d8:yml:links:task command.
 */
class Task extends ModuleGenerator {

  protected $name = 'd8:yml:links:task';
  protected $description = 'Generates a links.task yml file';
  protected $alias = 'task-links';
  protected $nameQuestion = NULL;

  /**
   * {@inheritdoc}
   */
  protected function generate() :void {
    $this->collectDefault();
    $this->addFile('{machine_name}.links.task.yml', 'd8/yml/links.task');
  }

}
