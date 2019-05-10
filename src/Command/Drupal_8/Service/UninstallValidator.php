<?php

namespace DrupalCodeGenerator\Command\Drupal_8\Service;

use DrupalCodeGenerator\Command\ModuleGenerator;

/**
 * Implements d8:service:uninstall-validator command.
 */
class UninstallValidator extends ModuleGenerator {

  protected $name = 'd8:service:uninstall-validator';
  protected $description = 'Generates a uninstall validator service';
  protected $alias = 'uninstall-validator';

  /**
   * {@inheritdoc}
   */
  protected function generate() :void {
    $vars = &$this->collectDefault();
    $vars['class'] = $this->ask('Class', '{name|camelize}UninstallValidator');
    $this->addFile('src/{class}.php', 'd8/service/uninstall-validator');
    $this->addServicesFile()
      ->template('d8/service/uninstall-validator.services');
  }

}
