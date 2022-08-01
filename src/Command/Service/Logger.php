<?php declare(strict_types = 1);

namespace DrupalCodeGenerator\Command\Service;

use DrupalCodeGenerator\Application;
use DrupalCodeGenerator\Asset\AssetCollection as Assets;
use DrupalCodeGenerator\Attribute\Generator;
use DrupalCodeGenerator\Command\BaseGenerator;
use DrupalCodeGenerator\GeneratorType;

#[Generator(
  name: 'service:logger',
  description: 'Generates a logger service',
  aliases: ['logger'],
  templatePath: Application::TEMPLATE_PATH . '/service/logger',
  type: GeneratorType::MODULE_COMPONENT,
)]
final class Logger extends BaseGenerator {

  protected function generate(array &$vars, Assets $assets): void {
    $ir = $this->createInterviewer($vars);
    $vars['machine_name'] = $ir->askMachineName();

    $vars['class'] = $ir->ask('Class', 'FileLog');
    $assets->addFile('src/Logger/{class}.php', 'logger.twig');
    $assets->addServicesFile()->template('services.twig');
  }

}
