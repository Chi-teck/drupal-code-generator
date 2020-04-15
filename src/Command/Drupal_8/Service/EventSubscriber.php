<?php

namespace DrupalCodeGenerator\Command\Drupal_8\Service;

use DrupalCodeGenerator\Command\BaseGenerator;
use DrupalCodeGenerator\Utils;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;

/**
 * Implements d8:service:event-subscriber command.
 */
class EventSubscriber extends BaseGenerator {

  protected $name = 'd8:service:event-subscriber';
  protected $description = 'Generates an event subscriber';
  protected $alias = 'event-subscriber';

  /**
   * {@inheritdoc}
   */
  protected function interact(InputInterface $input, OutputInterface $output) {
    $questions = Utils::defaultQuestions();

    $default_class = function ($vars) {
      return Utils::camelize($vars['machine_name']) . 'Subscriber';
    };
    $questions['class'] = new Question('Class', $default_class);
    $questions['class']->setValidator([Utils::class, 'validateClassName']);

    $this->collectVars($input, $output, $questions);

    $this->addFile()
      ->path('src/EventSubscriber/{class}.php')
      ->template('d8/service/event-subscriber.twig');

    $this->addServicesFile()
      ->template('d8/service/event-subscriber.services.twig');
  }

}
