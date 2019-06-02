<?php

namespace DrupalCodeGenerator\Command\Service;

use DrupalCodeGenerator\Command\ModuleGenerator;

/**
 * Implements service:logger command.
 */
final class Logger extends ModuleGenerator {

  protected $name = 'service:logger';
  protected $description = 'Generates a logger service';
  protected $alias = 'logger';

  /**
   * {@inheritdoc}
   */
  protected function generate() :void {
    $vars = &$this->collectDefault();
    $vars['class'] = $this->ask('Class', 'FileLog');
    $this->addFile('src/Logger/{class}.php', 'service/logger');
    $this->addServicesFile()
      ->template('service/logger.services');
  }

}
