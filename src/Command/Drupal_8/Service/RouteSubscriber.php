<?php

namespace DrupalCodeGenerator\Command\Drupal_8\Service;

use DrupalCodeGenerator\Command\ModuleGenerator;

/**
 * Implements d8:service:route-subscriber command.
 */
class RouteSubscriber extends ModuleGenerator {

  protected $name = 'd8:service:route-subscriber';
  protected $description = 'Generates a route subscriber';
  protected $alias = 'route-subscriber';

  /**
   * {@inheritdoc}
   */
  protected function generate() :void {
    $vars = &$this->collectDefault();
    $vars['class'] = '{machine_name|camelize}RouteSubscriber';
    $this->addFile('src/EventSubscriber/{class}.php', 'd8/service/route-subscriber');
    $this->addServicesFile()
      ->template('d8/service/route-subscriber.services');
  }

}
