<?php

namespace DrupalCodeGenerator\Command\Drupal_8\Service;

use DrupalCodeGenerator\Command\BaseGenerator;
use DrupalCodeGenerator\Utils;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;

/**
 * Implements d8:service:route-subscriber command.
 */
class RouteSubscriber extends BaseGenerator {

  protected $name = 'd8:service:route-subscriber';
  protected $description = 'Generates a route subscriber';
  protected $alias = 'route-subscriber';

  /**
   * {@inheritdoc}
   */
  protected function interact(InputInterface $input, OutputInterface $output) {
    $questions = Utils::moduleQuestions();

    $default_class = function ($vars) {
      return Utils::camelize($vars['machine_name']) . 'RouteSubscriber';
    };
    $questions['class'] = new Question('Class', $default_class);
    $questions['class']->setValidator([Utils::class, 'validateClassName']);

    $this->collectVars($input, $output, $questions);

    $this->addFile()
      ->path('src/EventSubscriber/{class}.php')
      ->template('d8/service/route-subscriber.twig');

    $this->addServicesFile()
      ->template('d8/service/route-subscriber.services.twig');
  }

}
