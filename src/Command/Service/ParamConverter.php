<?php

declare(strict_types=1);

namespace DrupalCodeGenerator\Command\Service;

use DrupalCodeGenerator\Application;
use DrupalCodeGenerator\Asset\AssetCollection as Assets;
use DrupalCodeGenerator\Attribute\Generator;
use DrupalCodeGenerator\Command\BaseGenerator;
use DrupalCodeGenerator\GeneratorType;
use DrupalCodeGenerator\Validator\RegExp;

#[Generator(
  name: 'service:param-converter',
  description: 'Generates a param converter service',
  aliases: ['param-converter'],
  templatePath: Application::TEMPLATE_PATH . '/Service/_param-converter',
  type: GeneratorType::MODULE_COMPONENT,
)]
final class ParamConverter extends BaseGenerator {

  /**
   * {@inheritdoc}
   */
  protected function generate(array &$vars, Assets $assets): void {
    $ir = $this->createInterviewer($vars);
    $vars['machine_name'] = $ir->askMachineName();

    $type_validator = new RegExp('/^[a-z][a-z0-9_\:]*[a-z0-9]$/');
    $vars['parameter_type'] = $ir->ask('Parameter type', 'example', $type_validator);
    $vars['class'] = $ir->askClass(default: '{parameter_type|camelize}ParamConverter');
    $vars['services'] = $ir->askServices();
    $vars['controller_class'] = '{machine_name|camelize}Controller';

    $assets->addFile('src/{class}.php', 'param-converter.twig');
    $assets->addServicesFile()->template('services.twig');
  }

}
