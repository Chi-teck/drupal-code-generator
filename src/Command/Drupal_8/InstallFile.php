<?php

namespace DrupalCodeGenerator\Command\Drupal_8;

use DrupalCodeGenerator\Command\ModuleGenerator;
use DrupalCodeGenerator\Utils;

/**
 * Implements d8:install-file command.
 */
class InstallFile extends ModuleGenerator {

  protected $name = 'd8:install-file';
  protected $description = 'Generates an install file';
  protected $alias = 'install-file';

  /**
   * {@inheritdoc}
   */
  protected function generate() :void {
    $this->collectVars(Utils::moduleQuestions());
    $this->addFile()
      ->path('{machine_name}.install')
      ->template('d8/install.twig');
  }

}
