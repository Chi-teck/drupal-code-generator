<?php

namespace DrupalCodeGenerator\Command\Yml\Links;

use DrupalCodeGenerator\Command\ModuleGenerator;

/**
 * Implements yml:links:task command.
 */
final class Task extends ModuleGenerator {

  protected $name = 'yml:links:task';
  protected $description = 'Generates a links.task yml file';
  protected $alias = 'task-links';
  protected $nameQuestion = NULL;

  /**
   * {@inheritdoc}
   */
  protected function generate() :void {
    $this->collectDefault();
    $this->addFile('{machine_name}.links.task.yml', 'yml/links.task');
  }

}
