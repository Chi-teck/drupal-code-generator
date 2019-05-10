<?php

namespace DrupalCodeGenerator\Command\Drupal_8\Service;

use DrupalCodeGenerator\Command\ModuleGenerator;

/**
 * Implements d8:service:event-subscriber command.
 */
class EventSubscriber extends ModuleGenerator {

  protected $name = 'd8:service:event-subscriber';
  protected $description = 'Generates an event subscriber';
  protected $alias = 'event-subscriber';

  /**
   * {@inheritdoc}
   */
  protected function generate() :void {
    $vars = &$this->collectDefault();
    $vars['class'] = '{machine_name|camelize}Subscriber';
    $this->addFile('src/EventSubscriber/{class}.php', 'd8/service/event-subscriber');
    $this->addServicesFile()
      ->template('d8/service/event-subscriber.services');
  }

}
