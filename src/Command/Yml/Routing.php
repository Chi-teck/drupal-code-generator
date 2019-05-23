<?php

namespace DrupalCodeGenerator\Command\Yml;

use DrupalCodeGenerator\Command\ModuleGenerator;

/**
 * Implements yml:routing command.
 */
class Routing extends ModuleGenerator {

  protected $name = 'yml:routing';
  protected $description = 'Generates a routing yml file';
  protected $alias = 'routing';

  /**
   * {@inheritdoc}
   */
  protected function generate() :void {
    $vars = &$this->collectDefault();
    $vars['class'] = '{machine_name|camelize}Controller';
    $this->addFile('{machine_name}.routing.yml', 'yml/routing');
  }

}
