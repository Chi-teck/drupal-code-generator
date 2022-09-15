<?php declare(strict_types = 1);

namespace DrupalCodeGenerator\Command\Service;

use DrupalCodeGenerator\Application;
use DrupalCodeGenerator\Asset\AssetCollection as Assets;
use DrupalCodeGenerator\Attribute\Generator;
use DrupalCodeGenerator\Command\BaseGenerator;
use DrupalCodeGenerator\GeneratorType;

#[Generator(
  name: 'service:theme-negotiator',
  description: 'Generates a theme negotiator',
  aliases: ['theme-negotiator'],
  templatePath: Application::TEMPLATE_PATH . '/service/theme-negotiator',
  type: GeneratorType::MODULE_COMPONENT,
)]
final class ThemeNegotiator extends BaseGenerator {

  protected function generate(array &$vars, Assets $assets): void {
    $ir = $this->createInterviewer($vars);
    $vars['machine_name'] = $ir->askMachineName();
    $vars['class'] = $ir->ask('Class', '{machine_name|camelize}Negotiator');

    $assets->addFile('src/Theme/{class}.php', 'theme-negotiator.twig');
    $assets->addServicesFile()->template('services.twig');
  }

}
