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

    $vars = $this->collectVars($input, $output, $questions);
    $vars['class'] = Utils::camelize($vars['name'] . 'RouteSubscriber');

    $path = 'src/EventSubscriber/' . $vars['class'] . '.php';
    $this->setFile($path, 'd8/service/route-subscriber.twig', $vars);
    $this->setServicesFile($vars['machine_name'] . '.services.yml', 'd8/service/route-subscriber.services.twig', $vars);
  }

}
