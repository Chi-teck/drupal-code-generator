<?php

namespace DrupalCodeGenerator\Command\Drupal_8\Service;

use DrupalCodeGenerator\Command\ModuleGenerator;
use DrupalCodeGenerator\Utils;

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
    $questions = Utils::moduleQuestions();

    $vars = &$this->collectVars($questions);
    $vars['class'] = Utils::camelize($vars['name']) . 'Subscriber';

    $this->addFile()
      ->path('src/EventSubscriber/{class}.php')
      ->template('d8/service/event-subscriber.twig');

    $this->addServicesFile()
      ->template('d8/service/event-subscriber.services.twig');
  }

}
