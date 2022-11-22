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
  templatePath: Application::TEMPLATE_PATH . '/Service/_request-policy',
  type: GeneratorType::MODULE_COMPONENT,
)]
final class RequestPolicy extends BaseGenerator {

  /**
   * {@inheritdoc}
   */
  protected function generate(array &$vars, Assets $assets): void {
    $ir = $this->createInterviewer($vars);
    $vars['machine_name'] = $ir->askMachineName();
    $vars['class'] = $ir->askClass(default: 'Example');
    $vars['services'] = $ir->askServices();

    $assets->addFile('src/PageCache/{class}.php', 'request-policy.twig');
    $assets->addServicesFile()->template('services.twig');
  }

}
