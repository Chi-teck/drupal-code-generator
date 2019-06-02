<?php

namespace DrupalCodeGenerator\Command\Service;

use DrupalCodeGenerator\Command\ModuleGenerator;

/**
 * Implements service:uninstall-validator command.
 */
final class UninstallValidator extends ModuleGenerator {

  protected $name = 'service:uninstall-validator';
  protected $description = 'Generates a uninstall validator service';
  protected $alias = 'uninstall-validator';

  /**
   * {@inheritdoc}
   */
  protected function generate() :void {
    $vars = &$this->collectDefault();
    $vars['class'] = $this->ask('Class', '{name|camelize}UninstallValidator');
    $this->addFile('src/{class}.php', 'service/uninstall-validator');
    $this->addServicesFile()
      ->template('service/uninstall-validator.services');
  }

}
