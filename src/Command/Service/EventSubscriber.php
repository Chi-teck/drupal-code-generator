<?php

namespace DrupalCodeGenerator\Command\Service;

use DrupalCodeGenerator\Command\ModuleGenerator;

/**
 * Implements service:event-subscriber command.
 */
final class EventSubscriber extends ModuleGenerator {

  protected $name = 'service:event-subscriber';
  protected $description = 'Generates an event subscriber';
  protected $alias = 'event-subscriber';

  /**
   * {@inheritdoc}
   */
  protected function generate() :void {
    $vars = &$this->collectDefault();
    $vars['class'] = '{machine_name|camelize}Subscriber';
    $this->addFile('src/EventSubscriber/{class}.php', 'service/event-subscriber');
    $this->addServicesFile()
      ->template('service/event-subscriber.services');
  }

}
