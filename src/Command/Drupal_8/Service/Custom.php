<?php

namespace DrupalCodeGenerator\Command\Drupal_8\Service;

use DrupalCodeGenerator\Command\BaseGenerator;
use DrupalCodeGenerator\Utils;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;

/**
 * Implements d8:service:custom command.
 */
class Custom extends BaseGenerator {

  protected $name = 'd8:service:custom';
  protected $description = 'Generates a custom Drupal service';
  protected $alias = 'custom-service';
  protected $label = 'Custom service';

  /**
   * {@inheritdoc}
   */
  protected function interact(InputInterface $input, OutputInterface $output) {
    $questions = Utils::defaultQuestions();
    $questions['service_name'] = new Question('Service name', '{machine_name}.example');
    $questions['service_name']->setValidator(function ($value) {
      if (!preg_match('/^[a-z][a-z0-9_\.]*[a-z0-9]$/', $value)) {
        throw new \UnexpectedValueException('The value is not correct service name.');
      }
      return $value;
    });
    $default_class = function ($vars) {
      return Utils::camelize($vars['service_name']);
    };
    $questions['class'] = new Question('Class', $default_class);

    $this->collectVars($input, $output, $questions);

    $this->addFile()
      ->path('src/{class}.php')
      ->template('d8/service/custom.twig');

    $this->addServicesFile()
      ->template('d8/service/custom.services.twig');
  }

}
