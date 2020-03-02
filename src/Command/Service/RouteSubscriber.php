<?php

namespace DrupalCodeGenerator\Command\Service;

use DrupalCodeGenerator\Command\ModuleGenerator;

/**
 * Implements service:route-subscriber command.
 */
final class RouteSubscriber extends ModuleGenerator {

  protected $name = 'service:route-subscriber';
  protected $description = 'Generates a route subscriber';
  protected $alias = 'route-subscriber';

  /**
   * {@inheritdoc}
   */
  protected function generate(): void {
    $vars = &$this->collectDefault();
    $vars['class'] = $this->ask('Class', '{machine_name|camelize}RouteSubscriber');
    $this->collectServices(FALSE);
    $this->addFile('src/EventSubscriber/{class}.php', 'route-subscriber');
    $this->addServicesFile()->template('services');
  }

}
