<?php

namespace DrupalCodeGenerator\Command\Drupal_8;

use DrupalCodeGenerator\Command\ModuleGenerator;
use DrupalCodeGenerator\Utils;

/**
 * Implements d8:module-file command.
 */
class ModuleFile extends ModuleGenerator {

  protected $name = 'd8:module-file';
  protected $description = 'Generates a module file';
  protected $alias = 'module-file';

  /**
   * {@inheritdoc}
   */
  protected function generate() :void {
    $this->collectVars(Utils::moduleQuestions());
    $this->addFile()
      ->path('{machine_name}.module')
      ->template('d8/module.twig');
  }

}
