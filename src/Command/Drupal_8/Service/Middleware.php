<?php

namespace DrupalCodeGenerator\Command\Drupal_8\Service;

use DrupalCodeGenerator\Command\BaseGenerator;
use DrupalCodeGenerator\Utils;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;

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
    $questions = Utils::moduleQuestions();

    $default_class = function ($vars) {
      return Utils::camelize($vars['machine_name']) . 'Middleware';
    };
    $questions['class'] = new Question('Class', $default_class);
    $questions['class']->setValidator([Utils::class, 'validateClassName']);
    $this->collectVars($input, $output, $questions);

    $this->addFile()
      ->path('src/{class}.php')
      ->template('d8/service/middleware.twig');

    $this->addServicesFile()
      ->path('{machine_name}.services.yml')
      ->template('d8/service/middleware.services.twig');
  }

}
