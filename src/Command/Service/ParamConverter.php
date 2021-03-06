<?php

namespace DrupalCodeGenerator\Command\Service;

use DrupalCodeGenerator\Command\ModuleGenerator;

/**
 * Implements service:param-converter command.
 */
final class ParamConverter extends ModuleGenerator {

  protected $name = 'service:param-converter';
  protected $description = 'Generates a param converter service';
  protected $alias = 'param-converter';

  /**
   * {@inheritdoc}
   */
  protected function generate(array &$vars): void {
    $this->collectDefault($vars);

    $vars['parameter_type'] = $this->ask('Parameter type', 'example');
    $vars['class'] = $this->ask('Class', '{parameter_type|camelize}ParamConverter');
    $vars['controller_class'] = '{machine_name|camelize}Controller';

    $this->addFile('src/{class}.php', 'param-converter');
    $this->addServicesFile()->template('services');
  }

}
