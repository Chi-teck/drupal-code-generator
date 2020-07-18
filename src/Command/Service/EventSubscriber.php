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
  protected function generate(array &$vars): void {
    $this->collectDefault($vars);
    $vars['class'] = $this->ask('Class', '{machine_name|camelize}Subscriber');
    $this->collectServices($vars, FALSE);
    $this->addFile('src/EventSubscriber/{class}.php', 'event-subscriber');
    $this->addServicesFile()->template('services');
  }

}
