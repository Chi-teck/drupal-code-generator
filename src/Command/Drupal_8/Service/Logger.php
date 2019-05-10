<?php

namespace DrupalCodeGenerator\Command\Drupal_8\Service;

use DrupalCodeGenerator\Command\ModuleGenerator;

/**
 * Implements d8:service:logger command.
 */
class Logger extends ModuleGenerator {

  protected $name = 'd8:service:logger';
  protected $description = 'Generates a logger service';
  protected $alias = 'logger';

  /**
   * {@inheritdoc}
   */
  protected function generate() :void {
    $vars = &$this->collectDefault();
    $vars['class'] = $this->ask('Class', 'FileLog');
    $this->addFile('src/Logger/{class}.php', 'd8/service/logger');
    $this->addServicesFile()
      ->template('d8/service/logger.services');
  }

}
