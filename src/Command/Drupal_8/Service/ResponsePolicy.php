<?php

namespace DrupalCodeGenerator\Command\Drupal_8\Service;

use DrupalCodeGenerator\Command\ModuleGenerator;
use DrupalCodeGenerator\Utils;
use Symfony\Component\Console\Question\Question;

/**
 * Implements d8:service:response-policy command.
 */
class ResponsePolicy extends ModuleGenerator {

  protected $name = 'd8:service:response-policy';
  protected $description = 'Generates a response policy service';
  protected $alias = 'response-policy';

  /**
   * {@inheritdoc}
   */
  protected function generate() :void {
    $questions = Utils::moduleQuestions();
    $questions['class'] = new Question('Class', 'Example');
    $this->collectVars($questions);

    $this->addFile()
      ->path('src/PageCache/{class}.php')
      ->template('d8/service/response-policy.twig');

    $this->addServicesFile()
      ->template('d8/service/response-policy.services.twig');
  }

}
