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
  templatePath: Application::TEMPLATE_PATH . '/Service/_theme-negotiator',
  type: GeneratorType::MODULE_COMPONENT,
)]
final class ThemeNegotiator extends BaseGenerator {

  /**
   * {@inheritdoc}
   */
  protected function generate(array &$vars, Assets $assets): void {
    $ir = $this->createInterviewer($vars);
    $vars['machine_name'] = $ir->askMachineName();
    $vars['class'] = $ir->askClass(default: '{machine_name|camelize}Negotiator');
    $vars['services'] = $ir->askServices();

    $assets->addFile('src/Theme/{class}.php', 'theme-negotiator.twig');
    $assets->addServicesFile()->template('services.twig');
  }

}
