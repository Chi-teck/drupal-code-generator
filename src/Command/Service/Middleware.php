<?php

namespace DrupalCodeGenerator\Command\Service;

use DrupalCodeGenerator\Command\ModuleGenerator;

/**
 * Implements service:middleware command.
 */
final class Middleware extends ModuleGenerator {

  protected $name = 'service:middleware';
  protected $description = 'Generates a middleware';
  protected $alias = 'middleware';

  /**
   * {@inheritdoc}
   */
  protected function generate(): void {
    $vars = &$this->collectDefault();
    $vars['class'] = '{machine_name|camelize}Middleware';
    $this->addFile('src/{class}.php', 'middleware');
    $this->addServicesFile()->template('services');
  }

}
