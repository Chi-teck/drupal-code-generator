<?php declare(strict_types=1);

namespace DrupalCodeGenerator\Command\Service;

use DrupalCodeGenerator\Application;
use DrupalCodeGenerator\Command\ModuleGenerator;

/**
 * Implements service:event-subscriber command.
 */
final class EventSubscriber extends ModuleGenerator {

  protected string $name = 'service:event-subscriber';
  protected string $description = 'Generates an event subscriber';
  protected string $alias = 'event-subscriber';
  protected string $templatePath = Application::TEMPLATE_PATH . '/service/event-subscriber';

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
