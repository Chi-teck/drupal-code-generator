<?php

namespace DrupalCodeGenerator\Command\Service;

use DrupalCodeGenerator\Command\ModuleGenerator;

/**
 * Implements service:breadcrumb-builder command.
 */
final class BreadcrumbBuilder extends ModuleGenerator {

  protected $name = 'service:breadcrumb-builder';
  protected $description = 'Generates a breadcrumb builder service';
  protected $alias = 'breadcrumb-builder';

  /**
   * {@inheritdoc}
   */
  protected function generate() :void {
    $vars = &$this->collectDefault();
    $vars['class'] = $this->ask('Class', '{machine_name|camelize}BreadcrumbBuilder');
    $this->addFile('src/{class}.php', 'service/breadcrumb-builder');
    $this->addServicesFile()
      ->path('{machine_name}.services.yml')
      ->template('service/breadcrumb-builder.services');
  }

}
