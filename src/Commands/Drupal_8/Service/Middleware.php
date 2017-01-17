<?php

namespace DrupalCodeGenerator\Commands\Drupal_8\Service;

use DrupalCodeGenerator\Commands\BaseGenerator;
use DrupalCodeGenerator\Utils;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Implements d8:service:middleware command.
 */
class Middleware extends BaseGenerator {

  protected $name = 'd8:service:middleware';
  protected $description = 'Generates a middleware';
  protected $alias = 'middleware';

  /**
   * {@inheritdoc}
   */
  protected function interact(InputInterface $input, OutputInterface $output) {
    $questions = Utils::defaultQuestions();
    $vars = $this->collectVars($input, $output, $questions);
    $vars['class'] = Utils::human2class($vars['name'] . 'Middleware');

    $path = 'src/' . $vars['class'] . '.php';
    $this->files[$path] = $this->render('d8/service/middleware.twig', $vars);

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
