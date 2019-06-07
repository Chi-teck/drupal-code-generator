<?php

namespace DrupalCodeGenerator\Command\Service;

use DrupalCodeGenerator\Command\ModuleGenerator;

/**
 * Implements service:twig-extension command.
 */
final class TwigExtension extends ModuleGenerator {

  protected $name = 'service:twig-extension';
  protected $description = 'Generates Twig extension service';
  protected $alias = 'twig-extension';

  /**
   * {@inheritdoc}
   */
  protected function generate() :void {
    $vars = &$this->collectDefault();
    $vars['class'] = $this->ask('Class', '{machine_name|camelize}TwigExtension');
    $this->collectServices();
    $this->addFile('src/{class}.php', 'twig-extension');
    $this->addServicesFile()->template('services');
  }

}
