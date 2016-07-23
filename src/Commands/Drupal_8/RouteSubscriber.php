<?php

namespace DrupalCodeGenerator\Commands\Drupal_8;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use DrupalCodeGenerator\Commands\BaseGenerator;

/**
 * Implements d8:route-subscriber command.
 */
class RouteSubscriber extends BaseGenerator {

  protected $name = 'd8:route-subscriber';
  protected $description = 'Generates a route subscriber';
  protected $alias = 'route-subscriber';

  /**
   * {@inheritdoc}
   */
  protected function interact(InputInterface $input, OutputInterface $output) {
    $questions = [
      'name' => ['Module name', [$this, 'defaultName']],
      'machine_name' => ['Module machine name', [$this, 'defaultMachineName']],
    ];
    $vars = $this->collectVars($input, $output, $questions);
    $vars['class'] = $this->human2class($vars['name'] . 'RouteSubscriber');

    $path = $this->createPath('src/EventSubscriber/', $vars['class'] . '.php', $vars['machine_name']);
    $this->files[$path] = $this->render('d8/route-subscriber.twig', $vars);

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
