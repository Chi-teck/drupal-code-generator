<?php

namespace DrupalCodeGenerator\Command\Drupal_8\Service;

use DrupalCodeGenerator\Command\BaseGenerator;
use DrupalCodeGenerator\Utils;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;

/**
 * Implements d8:service:response-policy command.
 */
class ResponsePolicy extends BaseGenerator {

  protected $name = 'd8:service:response-policy';
  protected $description = 'Generates a response policy service';
  protected $alias = 'response-policy';

  /**
   * {@inheritdoc}
   */
  protected function interact(InputInterface $input, OutputInterface $output) {
    $questions = Utils::defaultQuestions();
    $questions['class'] = new Question('Class', 'Example');
    $this->collectVars($input, $output, $questions);

    $this->addFile()
      ->path('src/PageCache/{class}.php')
      ->template('d8/service/response-policy.twig');

    $this->addServicesFile()
      ->template('d8/service/response-policy.services.twig');
  }

}
