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
  protected function generate(array &$vars): void {
    $this->collectDefault($vars);
    $vars['class'] = $this->ask('Class', '{machine_name|camelize}Middleware');
    $this->addFile('src/{class}.php', 'middleware');
    $this->addServicesFile()->template('services');
  }

}
