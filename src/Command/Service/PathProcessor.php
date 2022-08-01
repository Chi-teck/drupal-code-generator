<?php declare(strict_types = 1);

namespace DrupalCodeGenerator\Command\Service;

use DrupalCodeGenerator\Application;
use DrupalCodeGenerator\Asset\AssetCollection as Assets;
use DrupalCodeGenerator\Attribute\Generator;
use DrupalCodeGenerator\Command\BaseGenerator;
use DrupalCodeGenerator\GeneratorType;

#[Generator(
  name: 'service:path-processor',
  description: 'Generates a path processor service',
  aliases: ['path-processor'],
  templatePath: Application::TEMPLATE_PATH . '/service/path-processor',
  type: GeneratorType::MODULE_COMPONENT,
)]
final class PathProcessor extends BaseGenerator {

  protected function generate(array &$vars, Assets $assets): void {
    $ir = $this->createInterviewer($vars);
    $vars['machine_name'] = $ir->askMachineName();
    $vars['class'] = $ir->ask('Class', 'PathProcessor{machine_name|camelize}');

    $assets->addFile('src/PathProcessor/{class}.php', 'path-processor');
    $assets->addServicesFile()->template('services');
  }

}
