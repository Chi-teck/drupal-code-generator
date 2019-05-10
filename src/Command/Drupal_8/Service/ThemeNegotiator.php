<?php

namespace DrupalCodeGenerator\Command\Drupal_8\Service;

use DrupalCodeGenerator\Command\ModuleGenerator;

/**
 * Implements d8:service:theme-negotiator command.
 */
class ThemeNegotiator extends ModuleGenerator {

  protected $name = 'd8:service:theme-negotiator';
  protected $description = 'Generates a theme negotiator';
  protected $alias = 'theme-negotiator';

  /**
   * {@inheritdoc}
   */
  protected function generate() :void {
    $vars = &$this->collectDefault();
    $vars['class'] = $this->ask('Class', '{machine_name|camelize}Negotiator');
    $this->addFile('src/Theme/{class}.php', 'd8/service/theme-negotiator');
    $this->addServicesFile()
      ->template('d8/service/theme-negotiator.services');
  }

}
