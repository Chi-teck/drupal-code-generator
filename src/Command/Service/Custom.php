<?php declare(strict_types=1);

namespace DrupalCodeGenerator\Command\Service;

use DrupalCodeGenerator\Application;
use DrupalCodeGenerator\Command\ModuleGenerator;
use DrupalCodeGenerator\Utils;

/**
 * Implements service:custom command.
 */
final class Custom extends ModuleGenerator {

  protected string $name = 'service:custom';
  protected string $description = 'Generates a custom Drupal service';
  protected string $alias = 'custom-service';
  protected string $templatePath = Application::TEMPLATE_PATH . '/service/custom';
  protected string $label = 'Custom service';

  /**
   * {@inheritdoc}
   */
  protected function generate(array &$vars): void {
    $this->collectDefault($vars);
    $vars['service_name'] = $this->ask('Service name', '{machine_name}.example', '::validateRequiredServiceName');

    $service = \preg_replace('/^' . $vars['machine_name'] . '/', '', $vars['service_name']);
    $vars['class'] = $this->ask('Class', Utils::camelize($service), '::validateRequiredClassName');

    $this->collectServices($vars);

    $this->addFile('src/{class}.php', 'custom');
    $this->addServicesFile()->template('services');
  }

}
