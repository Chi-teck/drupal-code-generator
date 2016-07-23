<?php

namespace DrupalCodeGenerator\Commands\Drupal_8;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use DrupalCodeGenerator\Commands\BaseGenerator;

/**
 * Implements d8:middleware command.
 */
class Middleware extends BaseGenerator {

  protected $name = 'd8:middleware';
  protected $description = 'Generates a middleware';
  protected $alias = 'middleware';

  /**
   * {@inheritdoc}
   */
  protected function interact(InputInterface $input, OutputInterface $output) {
    $questions = [
      'name' => ['Module name', [$this, 'defaultName']],
      'machine_name' => ['Module machine name', [$this, 'defaultMachineName']],
    ];
    $vars = $this->collectVars($input, $output, $questions);
    $vars['class'] = $this->human2class($vars['name'] . 'Middleware');

    $path = $this->createPath('src/', $vars['class'] . '.php', $vars['machine_name']);
    $this->files[$path] = $this->render('d8/middleware.twig', $vars);

    $this->services[$vars['machine_name'] . '.middleware'] = [
      'class' => 'Drupal\\' . $vars['machine_name'] . '\\' . $vars['class'],
      'tags' => [
        [
          'name' => 'http_middleware',
          'priority' => 1000,
        ],
      ],
    ];

  }

}
