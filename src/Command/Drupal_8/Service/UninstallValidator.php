<?php

namespace DrupalCodeGenerator\Command\Drupal_8\Service;

use DrupalCodeGenerator\Command\BaseGenerator;
use DrupalCodeGenerator\Utils;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;

/**
 * Implements d8:service:uninstall-validator command.
 */
class UninstallValidator extends BaseGenerator {

  protected $name = 'd8:service:uninstall-validator';
  protected $description = 'Generates a uninstall validator service';
  protected $alias = 'uninstall-validator';

  /**
   * {@inheritdoc}
   */
  protected function interact(InputInterface $input, OutputInterface $output) {
    $questions = Utils::defaultQuestions();
    $default_class = function ($vars) {
      return Utils::camelize($vars['machine_name']) . 'UninstallValidator';
    };
    $questions['class'] = new Question('Class', $default_class);
    $this->collectVars($input, $output, $questions);

    $this->addFile()
      ->path('src/{class}.php')
      ->template('d8/service/uninstall-validator.twig');

    $this->addServicesFile()
      ->template('d8/service/uninstall-validator.services.twig');
  }

}
