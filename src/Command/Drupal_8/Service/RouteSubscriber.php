<?php

namespace DrupalCodeGenerator\Command\Drupal_8\Service;

use DrupalCodeGenerator\Command\BaseGenerator;
use DrupalCodeGenerator\Utils;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

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
    $questions = Utils::defaultQuestions();

    $vars = &$this->collectVars($input, $output, $questions);
    $vars['class'] = Utils::camelize($vars['name']) . 'RouteSubscriber';

    $this->addFile()
      ->path('src/EventSubscriber/{class}.php')
      ->template('d8/service/route-subscriber.twig');

    $this->addServicesFile()
      ->template('d8/service/route-subscriber.services.twig');
  }

}
