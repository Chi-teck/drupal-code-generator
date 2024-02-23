<?php

declare(strict_types=1);

namespace DrupalCodeGenerator\Command\Service;

use DrupalCodeGenerator\Application;
use DrupalCodeGenerator\Asset\AssetCollection as Assets;
use DrupalCodeGenerator\Attribute\Generator;
use DrupalCodeGenerator\Command\BaseGenerator;
use DrupalCodeGenerator\GeneratorType;
use DrupalCodeGenerator\Validator\RegExp;

#[Generator(
  name: 'service:access-checker',
  description: 'Generates an access checker service',
  aliases: ['access-checker'],
  templatePath: Application::TEMPLATE_PATH . '/Service/_access-checker',
  type: GeneratorType::MODULE_COMPONENT,
)]
final class AccessChecker extends BaseGenerator {

  /**
   * {@inheritdoc}
   */
  protected function generate(array &$vars, Assets $assets): void {
    $ir = $this->createInterviewer($vars);
    $vars['machine_name'] = $ir->askMachineName();

    $validator = new RegExp(
      '/^_[a-z0-9_]*[a-z0-9]$/',
      'The value is not correct name for requirement name.',
    );
    $vars['requirement'] = $ir->ask('Requirement', '_foo', $validator);
    $vars['class'] = $ir->askClass(default: '{requirement|camelize}AccessChecker');
    $vars['services'] = $ir->askServices(FALSE);

    $assets->addFile('src/Access/{class}.php', 'access-checker.twig');
    $assets->addServicesFile()->template('services.twig');
  }

}
