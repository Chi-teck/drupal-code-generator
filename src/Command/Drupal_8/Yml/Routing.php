<?php

namespace DrupalCodeGenerator\Command\Drupal_8\Yml;

use DrupalCodeGenerator\Command\ModuleGenerator;

/**
 * Implements d8:yml:routing command.
 */
class Routing extends ModuleGenerator {

  protected $name = 'd8:yml:routing';
  protected $description = 'Generates a routing yml file';
  protected $alias = 'routing';

  /**
   * {@inheritdoc}
   */
  protected function generate() :void {
    $vars = &$this->collectDefault();
    $vars['class'] = '{machine_name|camelize}Controller';
    $this->addFile('{machine_name}.routing.yml', 'd8/yml/routing');
  }

}
