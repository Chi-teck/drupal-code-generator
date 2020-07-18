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
  protected function generate(array &$vars): void {
    $this->collectDefault($vars);
    $vars['class'] = $this->ask('Class', '{machine_name|camelize}Negotiator');
    $this->addFile('src/Theme/{class}.php', 'theme-negotiator');
    $this->addServicesFile()->template('services');
  }

}
