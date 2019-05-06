<?php

namespace DrupalCodeGenerator\Command\Drupal_7;

use DrupalCodeGenerator\Command\BaseGenerator;
use DrupalCodeGenerator\Utils;

/**
 * Implements d7:install-file command.
 */
class InstallFile extends BaseGenerator {

  protected $name = 'd7:install-file';
  protected $description = 'Generates Drupal 7 install file';

  /**
   * {@inheritdoc}
   */
  protected function generate() :void {
    $this->collectVars(Utils::moduleQuestions());
    $this->addFile()
      ->path('{machine_name}.install')
      ->template('d7/install.twig');
  }

}
