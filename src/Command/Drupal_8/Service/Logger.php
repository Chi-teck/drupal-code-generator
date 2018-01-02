<?php

namespace DrupalCodeGenerator\Command\Drupal_8\Service;

use DrupalCodeGenerator\Command\BaseGenerator;
use DrupalCodeGenerator\Utils;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;

/**
 * Implements d8:service:logger command.
 */
class Logger extends BaseGenerator {

  protected $name = 'd8:service:logger';
  protected $description = 'Generates a logger service';
  protected $alias = 'logger';

  /**
   * {@inheritdoc}
   */
  protected function interact(InputInterface $input, OutputInterface $output) {
    $questions = Utils::defaultQuestions();
    $questions['class'] = new Question('Class', 'FileLog');

    $this->collectVars($input, $output, $questions);

    $this->addFile()
      ->path('src/Logger/{class}.php')
      ->template('d8/service/logger.twig');

    $this->addServicesFile()
      ->template('d8/service/logger.services.twig');
  }

}
