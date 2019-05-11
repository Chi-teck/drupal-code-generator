<?php

namespace DrupalCodeGenerator\Command\Drupal_8\Yml;

use DrupalCodeGenerator\Command\ModuleGenerator;

/**
 * Implements d8:yml:services command.
 */
class Services extends ModuleGenerator {

  protected $name = 'd8:yml:services';
  protected $description = 'Generates a services yml file';
  protected $alias = 'services';

  /**
   * {@inheritdoc}
   */
  protected function generate() :void {
    $vars = &$this->collectDefault();
    $vars['class'] = '{machine_name|camelize}';
    $this->addFile('{machine_name}.services.yml', 'd8/yml/services');
  }

}
