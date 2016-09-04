<?php

namespace DrupalCodeGenerator\Commands\Drupal_8\Service;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use DrupalCodeGenerator\Commands\BaseGenerator;

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
    $questions = [
      'name' => ['Module name'],
      'machine_name' => ['Module machine name'],
    ];
    $vars = $this->collectVars($input, $output, $questions);
    $vars['class'] = $this->human2class($vars['name'] . 'RouteSubscriber');

    $path = $this->createPath('src/EventSubscriber/', $vars['class'] . '.php', $vars['machine_name']);
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
