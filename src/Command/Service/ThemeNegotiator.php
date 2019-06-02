<?php

namespace DrupalCodeGenerator\Command\Service;

use DrupalCodeGenerator\Command\ModuleGenerator;

/**
 * Implements service:theme-negotiator command.
 */
final class ThemeNegotiator extends ModuleGenerator {

  protected $name = 'service:theme-negotiator';
  protected $description = 'Generates a theme negotiator';
  protected $alias = 'theme-negotiator';

  /**
   * {@inheritdoc}
   */
  protected function generate() :void {
    $vars = &$this->collectDefault();
    $vars['class'] = $this->ask('Class', '{machine_name|camelize}Negotiator');
    $this->addFile('src/Theme/{class}.php', 'service/theme-negotiator');
    $this->addServicesFile()
      ->template('service/theme-negotiator.services');
  }

}
