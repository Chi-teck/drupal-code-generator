<?php

namespace DrupalCodeGenerator\Command\Drupal_8;

use DrupalCodeGenerator\Command\ModuleGenerator;

/**
 * Implements d8:service-provider command.
 */
class ServiceProvider extends ModuleGenerator {

  protected $name = 'd8:service-provider';
  protected $description = 'Generates a service provider';
  protected $alias = 'service-provider';

  /**
   * {@inheritdoc}
   */
  protected function generate() :void {
    $vars = &$this->collectDefault();
    $vars['class'] = '{machine_name|camelize}ServiceProvider';
    $this->addFile('src/{class}.php', 'd8/service-provider');
  }

}
