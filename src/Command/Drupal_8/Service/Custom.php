<?php

namespace DrupalCodeGenerator\Command\Drupal_8\Service;

use DrupalCodeGenerator\Command\ModuleGenerator;
use DrupalCodeGenerator\Utils;

/**
 * Implements d8:service:custom command.
 */
class Custom extends ModuleGenerator {

  protected $name = 'd8:service:custom';
  protected $description = 'Generates a custom Drupal service';
  protected $alias = 'custom-service';
  protected $label = 'Custom service';

  /**
   * {@inheritdoc}
   */
  protected function generate() :void {
    $vars = &$this->collectDefault();
    $vars['service_name'] = $this->ask('Service name', '{machine_name}.example', [Utils::class, 'validateServiceName']);

    $service = preg_replace('/^' . $vars['machine_name'] . '/', '', $vars['service_name']);
    $vars['class'] = $this->ask('Class', Utils::camelize($service), [Utils::class, 'validateClassName']);

    $this->collectServices();

    $this->addFile('src/{class}.php', 'd8/service/custom');
    $this->addServicesFile()
      ->template('d8/service/custom.services.twig');
  }

}
