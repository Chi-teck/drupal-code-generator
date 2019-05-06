<?php

namespace DrupalCodeGenerator\Command\Drupal_8\Service;

use DrupalCodeGenerator\Command\ModuleGenerator;
use DrupalCodeGenerator\Utils;
use Symfony\Component\Console\Question\Question;

/**
 * Implements d8:service:logger command.
 */
class Logger extends ModuleGenerator {

  protected $name = 'd8:service:logger';
  protected $description = 'Generates a logger service';
  protected $alias = 'logger';

  /**
   * {@inheritdoc}
   */
  protected function generate() :void {
    $questions = Utils::moduleQuestions();
    $questions['class'] = new Question('Class', 'FileLog');

    $this->collectVars($questions);

    $this->addFile()
      ->path('src/Logger/{class}.php')
      ->template('d8/service/logger.twig');

    $this->addServicesFile()
      ->template('d8/service/logger.services.twig');
  }

}
