<?php declare(strict_types = 1);

namespace DrupalCodeGenerator\Command\Service;

use DrupalCodeGenerator\Application;
use DrupalCodeGenerator\Asset\AssetCollection as Assets;
use DrupalCodeGenerator\Attribute\Generator;
use DrupalCodeGenerator\Command\BaseGenerator;
use DrupalCodeGenerator\GeneratorType;

#[Generator(
  name: 'service:response-policy',
  description: 'Generates a response policy service',
  aliases: ['response-policy'],
  templatePath: Application::TEMPLATE_PATH . '/service/response-policy',
  type: GeneratorType::MODULE_COMPONENT,
)]
final class ResponsePolicy extends BaseGenerator {

  protected function generate(array &$vars, Assets $assets): void {
    $ir = $this->createInterviewer($vars);
    $vars['machine_name'] = $ir->askMachineName();
    $vars['class'] = $ir->ask('Class', 'Example');

    $assets->addFile('src/PageCache/{class}.php', 'response-policy');
    $assets->addServicesFile()->template('services');
  }

}
