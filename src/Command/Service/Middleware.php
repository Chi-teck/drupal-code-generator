<?php declare(strict_types=1);

namespace DrupalCodeGenerator\Command\Service;

use DrupalCodeGenerator\Application;
use DrupalCodeGenerator\Asset\AssetCollection;
use DrupalCodeGenerator\Attribute\Generator;
use DrupalCodeGenerator\Command\BaseGenerator;
use DrupalCodeGenerator\GeneratorType;

#[Generator(
  name: 'service:middleware',
  description: 'Generates a middleware',
  aliases: ['middleware'],
  templatePath: Application::TEMPLATE_PATH . '/service/middleware',
  type: GeneratorType::MODULE_COMPONENT,
)]
final class Middleware extends BaseGenerator {

  protected function generate(array &$vars, AssetCollection $assets): void {
    $ir = $this->createInterviewer($vars);
    $vars['machine_name'] = $ir->askMachineName();
    $vars['class'] = $ir->askClass(default: '{machine_name|camelize}Middleware');
    $assets->addFile('src/{class}.php', 'middleware.twig');
    $assets->addServicesFile()->template('services.twig');
  }

}
