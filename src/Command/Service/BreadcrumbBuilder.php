<?php declare(strict_types=1);

namespace DrupalCodeGenerator\Command\Service;

use DrupalCodeGenerator\Application;
use DrupalCodeGenerator\Command\ModuleGenerator;

/**
 * Implements service:breadcrumb-builder command.
 */
final class BreadcrumbBuilder extends ModuleGenerator {

  protected string $name = 'service:breadcrumb-builder';
  protected string $description = 'Generates a breadcrumb builder service';
  protected string $alias = 'breadcrumb-builder';
  protected string $templatePath = Application::TEMPLATE_PATH . '/service/breadcrumb-builder';

  /**
   * {@inheritdoc}
   */
  protected function generate(array &$vars): void {
    $this->collectDefault($vars);
    $vars['class'] = $this->ask('Class', '{machine_name|camelize}BreadcrumbBuilder');
    $this->addFile('src/{class}.php', 'breadcrumb-builder');
    $this->addServicesFile()->template('services');
  }

}
