<?php declare(strict_types = 1);

namespace DrupalCodeGenerator\Command\Service;

use DrupalCodeGenerator\Application;
use DrupalCodeGenerator\Asset\AssetCollection as Assets;
use DrupalCodeGenerator\Attribute\Generator;
use DrupalCodeGenerator\Command\BaseGenerator;
use DrupalCodeGenerator\GeneratorType;

#[Generator(
  name: 'service:uninstall-validator',
  description: 'Generates a uninstall validator service',
  aliases: ['uninstall-validator'],
  templatePath: Application::TEMPLATE_PATH . '/Service/_uninstall-validator',
  type: GeneratorType::MODULE_COMPONENT,
)]
final class UninstallValidator extends BaseGenerator {

  /**
   * {@inheritdoc}
   */
  protected function generate(array &$vars, Assets $assets): void {
    $ir = $this->createInterviewer($vars);
    $vars['machine_name'] = $ir->askMachineName();
    $vars['name'] = $ir->askName();
    $vars['class'] = $ir->askClass(default: '{name|camelize}UninstallValidator');
    $vars['services'] = $ir->askServices();

    $assets->addFile('src/{class}.php', 'uninstall-validator.twig');
    $assets->addServicesFile()->template('services.twig');
  }

}
