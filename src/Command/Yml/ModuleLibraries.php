<?php

namespace DrupalCodeGenerator\Command\Yml;

use DrupalCodeGenerator\Command\ModuleGenerator;

/**
 * Implements yml:module-libraries command.
 */
class ModuleLibraries extends ModuleGenerator {

  protected $name = 'yml:module-libraries';
  protected $description = 'Generates module libraries yml file';
  protected $alias = 'module-libraries';
  protected $label = 'Libraries (module)';
  protected $nameQuestion = NULL;

  /**
   * {@inheritdoc}
   */
  protected function generate() :void {
    $this->collectDefault();
    $this->addFile('{machine_name}.libraries.yml', 'yml/module-libraries');
  }

}
