<?php

namespace DrupalCodeGenerator\Command\Drupal_8\Service;

use DrupalCodeGenerator\Command\ModuleGenerator;
use DrupalCodeGenerator\Utils;
use Symfony\Component\Console\Question\Question;

/**
 * Implements d8:service:theme-negotiator command.
 */
class ThemeNegotiator extends ModuleGenerator {

  protected $name = 'd8:service:theme-negotiator';
  protected $description = 'Generates a theme negotiator';
  protected $alias = 'theme-negotiator';

  /**
   * {@inheritdoc}
   */
  protected function generate() :void {
    $questions = Utils::moduleQuestions();
    $default_class = function ($vars) {
      return Utils::camelize($vars['name']) . 'Negotiator';
    };
    $questions['class'] = new Question('Class', $default_class);

    $this->collectVars($questions);

    $this->addFile()
      ->path('src/Theme/{class}.php')
      ->template('d8/service/theme-negotiator.twig');

    $this->addServicesFile()
      ->template('d8/service/theme-negotiator.services.twig');
  }

}
