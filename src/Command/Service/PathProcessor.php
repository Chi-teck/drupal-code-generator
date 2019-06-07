<?php

namespace DrupalCodeGenerator\Command\Service;

use DrupalCodeGenerator\Command\ModuleGenerator;

/**
 * Implements service:path-processor command.
 */
final class PathProcessor extends ModuleGenerator {

  protected $name = 'service:path-processor';
  protected $description = 'Generates a path processor service';
  protected $alias = 'path-processor';

  /**
   * {@inheritdoc}
   */
  protected function generate() :void {
    $vars = &$this->collectDefault();
    $vars['class'] = $this->ask('Class', 'PathProcessor{machine_name|camelize}');

    $this->addFile('src/PathProcessor/{class}.php', 'path-processor');
    $this->addServicesFile()->template('services');
  }

}
