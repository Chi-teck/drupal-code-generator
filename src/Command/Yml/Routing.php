<?php

namespace DrupalCodeGenerator\Command\Yml;

use DrupalCodeGenerator\Command\ModuleGenerator;

/**
 * Implements yml:routing command.
 */
final class Routing extends ModuleGenerator {

  protected $name = 'yml:routing';
  protected $description = 'Generates a routing yml file';
  protected $alias = 'routing';

  /**
   * {@inheritdoc}
   */
  protected function generate(array &$vars): void {
    $this->collectDefault($vars);
    $vars['class'] = '{machine_name|camelize}Controller';
    $this->addFile('{machine_name}.routing.yml', 'routing');
  }

}
