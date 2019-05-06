<?php

namespace DrupalCodeGenerator\Command\Drupal_8\Service;

use DrupalCodeGenerator\Command\ModuleGenerator;
use DrupalCodeGenerator\Utils;
use Symfony\Component\Console\Question\Question;

/**
 * Implements d8:service:uninstall-validator command.
 */
class UninstallValidator extends ModuleGenerator {

  protected $name = 'd8:service:uninstall-validator';
  protected $description = 'Generates a uninstall validator service';
  protected $alias = 'uninstall-validator';

  /**
   * {@inheritdoc}
   */
  protected function generate() :void {
    $questions = Utils::moduleQuestions();
    $default_class = function ($vars) {
      return Utils::camelize($vars['name']) . 'UninstallValidator';
    };
    $questions['class'] = new Question('Class', $default_class);
    $this->collectVars($questions);

    $this->addFile()
      ->path('src/{class}.php')
      ->template('d8/service/uninstall-validator.twig');

    $this->addServicesFile()
      ->template('d8/service/uninstall-validator.services.twig');
  }

}
