<?php declare(strict_types=1);

namespace DrupalCodeGenerator\Command\Service;

use DrupalCodeGenerator\Application;
use DrupalCodeGenerator\Command\ModuleGenerator;

/**
 * Implements service:param-converter command.
 */
final class ParamConverter extends ModuleGenerator {

  protected string $name = 'service:param-converter';
  protected string $description = 'Generates a param converter service';
  protected string $alias = 'param-converter';
  protected string $templatePath = Application::TEMPLATE_PATH . '/service/param-converter';

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
