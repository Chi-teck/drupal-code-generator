<?php declare(strict_types = 1);

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
  templatePath: Application::TEMPLATE_PATH . '/Service/_middleware',
  type: GeneratorType::MODULE_COMPONENT,
)]
final class Middleware extends BaseGenerator {

  /**
   * {@inheritdoc}
   */
  protected function generate(array &$vars, AssetCollection $assets): void {
    $ir = $this->createInterviewer($vars);
    $vars['machine_name'] = $ir->askMachineName();

    $vars['class'] = $ir->askClass(default: '{machine_name|camelize}Middleware');
    $vars['services'] = $ir->askServices(forced_services: ['http_kernel']);
    // HTTP kernel argument should not be included to services definition as it
    // is added by container compiler pass.
    $vars['service_arguments'] = $vars['services'];
    unset($vars['service_arguments']['http_kernel']);

    $assets->addFile('src/{class}.php', 'middleware.twig');
    $assets->addServicesFile()->template('services.twig');
  }

}
