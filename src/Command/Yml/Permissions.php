<?php

namespace DrupalCodeGenerator\Command\Yml;

use DrupalCodeGenerator\Command\ModuleGenerator;

/**
 * Implements yml:permissions command.
 */
final class Permissions extends ModuleGenerator {

  protected $name = 'yml:permissions';
  protected $description = 'Generates a permissions yml file';
  protected $alias = 'permissions';
  protected $nameQuestion = NULL;

  /**
   * {@inheritdoc}
   */
  protected function generate(array &$vars): void {
    $this->collectDefault($vars);
    $this->addFile('{machine_name}.permissions.yml', 'permissions');
  }

}
