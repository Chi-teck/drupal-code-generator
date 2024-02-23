<?php

declare(strict_types=1);

namespace DrupalCodeGenerator\Command\Service;

use DrupalCodeGenerator\Application;
use DrupalCodeGenerator\Asset\AssetCollection as Assets;
use DrupalCodeGenerator\Attribute\Generator;
use DrupalCodeGenerator\Command\BaseGenerator;
use DrupalCodeGenerator\GeneratorType;
use DrupalCodeGenerator\Utils;
use DrupalCodeGenerator\Validator\RequiredServiceName;

#[Generator(
  name: 'service:custom',
  description: 'Generates a custom Drupal service',
  aliases: ['custom-service'],
  templatePath: Application::TEMPLATE_PATH . '/Service/_custom',
  type: GeneratorType::MODULE_COMPONENT,
  label: 'Custom service',
)]
final class Custom extends BaseGenerator {

  /**
   * {@inheritdoc}
   */
  protected function generate(array &$vars, Assets $assets): void {
    $ir = $this->createInterviewer($vars);
    $vars['machine_name'] = $ir->askMachineName();

    $vars['service_name'] = $ir->ask('Service name', '{machine_name}.example', new RequiredServiceName());

    $default_class = Utils::camelize(
      Utils::removePrefix($vars['service_name'], $vars['machine_name']) ?: $vars['machine_name'],
    );
    $vars['class'] = $ir->askClass(default: $default_class);
    $vars['interface'] = $ir->confirm('Would like to create an interface for this class?', FALSE) ?
      '{class}Interface' : NULL;

    $vars['services'] = $ir->askServices();

    $assets->addServicesFile()->template('services.twig');
    $assets->addFile('src/{class}.php', 'custom.twig');
    if ($vars['interface']) {
      $assets->addFile('src/{interface}.php', 'interface.twig');
    }
  }

}
