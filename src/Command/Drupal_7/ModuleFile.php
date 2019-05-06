<?php

namespace DrupalCodeGenerator\Command\Drupal_7;

use DrupalCodeGenerator\Command\BaseGenerator;
use DrupalCodeGenerator\Utils;

/**
 * Implements d7:module-file command.
 */
class ModuleFile extends BaseGenerator {

  protected $name = 'd7:module-file';
  protected $description = 'Generates Drupal 7 module file';

  /**
   * {@inheritdoc}
   */
  protected function generate() :void {
    $this->collectVars(Utils::moduleQuestions());
    $this->addFile()
      ->path('{machine_name}.module')
      ->template('d7/module.twig');
  }

}
