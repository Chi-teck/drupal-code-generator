<?php

namespace DrupalCodeGenerator\Command\Drupal_8\Service;

use DrupalCodeGenerator\Command\ModuleGenerator;

/**
 * Implements d8:service:middleware command.
 */
class Middleware extends ModuleGenerator {

  protected $name = 'd8:service:middleware';
  protected $description = 'Generates a middleware';
  protected $alias = 'middleware';

  /**
   * {@inheritdoc}
   */
  protected function generate() :void {
    $vars = &$this->collectDefault();
    $vars['class'] = '{machine_name|camelize}Middleware';
    $this->addFile('src/{class}.php', 'd8/service/middleware');
    $this->addServicesFile('{machine_name}.services.yml')
      ->template('d8/service/middleware.services');
  }

}
