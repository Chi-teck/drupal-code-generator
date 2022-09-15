<?php declare(strict_types = 1);

namespace DrupalCodeGenerator\Command\Service;

use DrupalCodeGenerator\Application;
use DrupalCodeGenerator\Asset\AssetCollection as Assets;
use DrupalCodeGenerator\Attribute\Generator;
use DrupalCodeGenerator\Command\BaseGenerator;
use DrupalCodeGenerator\GeneratorType;

#[Generator(
  name: 'service:request-policy',
  description: 'Generates a request policy service',
  aliases: ['request-policy'],
  templatePath: Application::TEMPLATE_PATH . '/service/request-policy',
  type: GeneratorType::MODULE_COMPONENT,
)]
final class RequestPolicy extends BaseGenerator {

  protected function generate(array &$vars, Assets $assets): void {
    $ir = $this->createInterviewer($vars);
    $vars['machine_name'] = $ir->askMachineName();
    $vars['class'] = $ir->ask('Class', 'Example');

    $assets->addFile('src/PageCache/{class}.php', 'request-policy.twig');
    $assets->addServicesFile()->template('services.twig');
  }

}
