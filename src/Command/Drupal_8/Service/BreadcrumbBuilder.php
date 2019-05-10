<?php

namespace DrupalCodeGenerator\Command\Drupal_8\Service;

use DrupalCodeGenerator\Command\ModuleGenerator;

/**
 * Implements d8:service:breadcrumb-builder command.
 */
class BreadcrumbBuilder extends ModuleGenerator {

  protected $name = 'd8:service:breadcrumb-builder';
  protected $description = 'Generates a breadcrumb builder service';
  protected $alias = 'breadcrumb-builder';

  /**
   * {@inheritdoc}
   */
  protected function generate() :void {
    $vars = &$this->collectDefault();
    $vars['class'] = $this->ask('Class', '{machine_name|camelize}BreadcrumbBuilder');
    $this->addFile('src/{class}.php', 'd8/service/breadcrumb-builder');
    $this->addServicesFile()
      ->path('{machine_name}.services.yml')
      ->template('d8/service/breadcrumb-builder.services');
  }

}
