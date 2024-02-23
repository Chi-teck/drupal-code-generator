<?php

declare(strict_types=1);

namespace DrupalCodeGenerator\Command\Service;

use DrupalCodeGenerator\Application;
use DrupalCodeGenerator\Asset\AssetCollection as Assets;
use DrupalCodeGenerator\Attribute\Generator;
use DrupalCodeGenerator\Command\BaseGenerator;
use DrupalCodeGenerator\GeneratorType;

#[Generator(
  name: 'service:breadcrumb-builder',
  description: 'Generates a breadcrumb builder service',
  aliases: ['breadcrumb-builder'],
  templatePath: Application::TEMPLATE_PATH . '/Service/_breadcrumb-builder',
  type: GeneratorType::MODULE_COMPONENT,
)]
final class BreadcrumbBuilder extends BaseGenerator {

  /**
   * {@inheritdoc}
   */
  protected function generate(array &$vars, Assets $assets): void {
    $ir = $this->createInterviewer($vars);
    $vars['machine_name'] = $ir->askMachineName();
    $vars['class'] = $ir->askClass(default: '{machine_name|camelize}BreadcrumbBuilder');
    $vars['services'] = $ir->askServices();
    $assets->addFile('src/{class}.php', 'breadcrumb-builder.twig');
    $assets->addServicesFile()->template('services.twig');
  }

}
