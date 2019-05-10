<?php

namespace DrupalCodeGenerator\Command\Drupal_8\Service;

use DrupalCodeGenerator\Command\ModuleGenerator;

/**
 * Implements d8:service:twig-extension command.
 */
class TwigExtension extends ModuleGenerator {

  protected $name = 'd8:service:twig-extension';
  protected $description = 'Generates Twig extension service';
  protected $alias = 'twig-extension';

  /**
   * {@inheritdoc}
   */
  protected function generate() :void {
    $vars = &$this->collectDefault();
    $vars['class'] = $this->ask('Class', '{machine_name|camelize}TwigExtension');

    if ($this->confirm('Would you like to inject dependencies?')) {
      $this->collectServices();
    }

    $this->addFile('src/{class}.php', 'd8/service/twig-extension');
    $this->addServicesFile()
      ->template('d8/service/twig-extension.services');
  }

}
