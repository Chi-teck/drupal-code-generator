<?php

namespace DrupalCodeGenerator\Commands\Drupal_8\Service;

use DrupalCodeGenerator\Commands\BaseGenerator;
use DrupalCodeGenerator\Commands\Utils;
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
    $vars['class'] = Utils::human2class($vars['name'] . 'RouteSubscriber');

    $path = 'src/EventSubscriber/' . $vars['class'] . '.php';
    $this->files[$path] = $this->render('d8/service/route-subscriber.twig', $vars);

    $this->services[$vars['machine_name'] . '.route_subscriber'] = [
      'class' => 'Drupal\\' . $vars['machine_name'] . '\\EventSubscriber\\' . $vars['class'],
      'tags' => [
        [
          'name' => 'event_subscriber',
        ],
      ],
    ];
  }

}
