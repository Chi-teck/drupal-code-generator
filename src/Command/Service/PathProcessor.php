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
  templatePath: Application::TEMPLATE_PATH . '/Service/_path-processor',
  type: GeneratorType::MODULE_COMPONENT,
)]
final class PathProcessor extends BaseGenerator {

  /**
   * {@inheritdoc}
   */
  protected function generate(array &$vars, Assets $assets): void {
    $ir = $this->createInterviewer($vars);
    $vars['machine_name'] = $ir->askMachineName();
    $vars['class'] = $ir->askClass(default: 'PathProcessor{machine_name|camelize}');
    $vars['services'] = $ir->askServices();

    $assets->addFile('src/PathProcessor/{class}.php', 'path-processor.twig');
    $assets->addServicesFile()->template('services.twig');
  }

}
