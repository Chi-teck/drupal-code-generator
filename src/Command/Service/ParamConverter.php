<?php declare(strict_types = 1);

namespace DrupalCodeGenerator\Command\Service;

use DrupalCodeGenerator\Application;
use DrupalCodeGenerator\Asset\AssetCollection as Assets;
use DrupalCodeGenerator\Attribute\Generator;
use DrupalCodeGenerator\Command\BaseGenerator;
use DrupalCodeGenerator\GeneratorType;

#[Generator(
  name: 'service:param-converter',
  description: 'Generates a param converter service',
  aliases: ['param-converter'],
  templatePath: Application::TEMPLATE_PATH . '/service/param-converter',
  type: GeneratorType::MODULE_COMPONENT,
)]
final class ParamConverter extends BaseGenerator {

  protected function generate(array &$vars, Assets $assets): void {
    $ir = $this->createInterviewer($vars);
    $vars['machine_name'] = $ir->askMachineName();

    $vars['parameter_type'] = $ir->ask('Parameter type', 'example');
    $vars['class'] = $ir->ask('Class', '{parameter_type|camelize}ParamConverter');
    $vars['controller_class'] = '{machine_name|camelize}Controller';

    $assets->addFile('src/{class}.php', 'param-converter');
    $assets->addServicesFile()->template('services');
  }

}
