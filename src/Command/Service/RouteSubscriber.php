<?php declare(strict_types=1);

namespace DrupalCodeGenerator\Command\Service;

use DrupalCodeGenerator\Application;
use DrupalCodeGenerator\Command\ModuleGenerator;

/**
 * Implements service:route-subscriber command.
 */
final class RouteSubscriber extends ModuleGenerator {

  protected string $name = 'service:route-subscriber';
  protected string $description = 'Generates a route subscriber';
  protected string $alias = 'route-subscriber';
  protected string $templatePath = Application::TEMPLATE_PATH . '/service/route-subscriber';

  /**
   * {@inheritdoc}
   */
  protected function generate(array &$vars): void {
    $this->collectDefault($vars);
    $vars['class'] = $this->ask('Class', '{machine_name|camelize}RouteSubscriber');
    $this->collectServices($vars, FALSE);
    $this->addFile('src/EventSubscriber/{class}.php', 'route-subscriber');
    $this->addServicesFile()->template('services');
  }

}
