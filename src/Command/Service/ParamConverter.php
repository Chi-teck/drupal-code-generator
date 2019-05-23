<?php

namespace DrupalCodeGenerator\Command\Service;

use DrupalCodeGenerator\Command\ModuleGenerator;

/**
 * Implements service:param-converter command.
 */
class ParamConverter extends ModuleGenerator {

  protected $name = 'service:param-converter';
  protected $description = 'Generates a param converter service';
  protected $alias = 'param-converter';

  /**
   * {@inheritdoc}
   */
  protected function generate() :void {
    $vars = &$this->collectDefault();

    $vars['parameter_type'] = $this->ask('Parameter type', 'example');
    $vars['class'] = $this->ask('Class', '{parameter_type|camelize}ParamConverter');
    $vars['controller_class'] = '{machine_name|camelize}Controller';

    $this->addFile('src/{class}.php', 'service/param-converter');
    $this->addServicesFile()
      ->path('{machine_name}.services.yml')
      ->template('service/param-converter.services');
  }

}
