<?php

namespace DrupalCodeGenerator\Command\Drupal_8\Service;

use DrupalCodeGenerator\Command\BaseGenerator;
use DrupalCodeGenerator\Utils;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;

/**
 * Implements d8:service:path-processor command.
 */
class PathProcessor extends BaseGenerator {

  protected $name = 'd8:service:path-processor';
  protected $description = 'Generates a path processor service';
  protected $alias = 'path-processor';

  /**
   * {@inheritdoc}
   */
  protected function interact(InputInterface $input, OutputInterface $output) {
    $questions = Utils::defaultQuestions();
    $default_class = function ($vars) {
      return Utils::camelize('PathProcessor' . $vars['name']);
    };
    $questions['class'] = new Question('Class', $default_class);

    $this->collectVars($input, $output, $questions);

    $this->addFile()
      ->path('src/PathProcessor/{class}.php')
      ->template('d8/service/path-processor.twig');

    $this->addServicesFile()
      ->template('d8/service/path-processor.services.twig');
  }

}
