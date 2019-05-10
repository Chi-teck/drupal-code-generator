<?php

namespace DrupalCodeGenerator\Command\Drupal_8\Service;

use DrupalCodeGenerator\Command\ModuleGenerator;

/**
 * Implements d8:service:path-processor command.
 */
class PathProcessor extends ModuleGenerator {

  protected $name = 'd8:service:path-processor';
  protected $description = 'Generates a path processor service';
  protected $alias = 'path-processor';

  /**
   * {@inheritdoc}
   */
  protected function generate() :void {
    $vars = &$this->collectDefault();
    $vars['class'] = $this->ask('Class', 'PathProcessor{machine_name|camelize}');

    $this->addFile('src/PathProcessor/{class}.php', 'd8/service/path-processor');
    $this->addServicesFile()
      ->template('d8/service/path-processor.services');
  }

}
