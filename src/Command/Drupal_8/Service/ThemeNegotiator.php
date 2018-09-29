<?php

namespace DrupalCodeGenerator\Command\Drupal_8\Service;

use DrupalCodeGenerator\Command\BaseGenerator;
use DrupalCodeGenerator\Utils;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;

/**
 * Implements d8:service:theme-negotiator command.
 */
class ThemeNegotiator extends BaseGenerator {

  protected $name = 'd8:service:theme-negotiator';
  protected $description = 'Generates a theme negotiator';
  protected $alias = 'theme-negotiator';

  /**
   * {@inheritdoc}
   */
  protected function interact(InputInterface $input, OutputInterface $output) {
    $questions = Utils::defaultQuestions();
    $default_class = function ($vars) {
      return Utils::camelize($vars['name']) . 'Negotiator';
    };
    $questions['class'] = new Question('Class', $default_class);

    $this->collectVars($input, $output, $questions);

    $this->addFile()
      ->path('src/Theme/{class}.php')
      ->template('d8/service/theme-negotiator.twig');

    $this->addServicesFile()
      ->template('d8/service/theme-negotiator.services.twig');
  }

}
