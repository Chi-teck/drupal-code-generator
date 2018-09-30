<?php

namespace DrupalCodeGenerator\Command\Drupal_8\Service;

use DrupalCodeGenerator\Command\BaseGenerator;
use DrupalCodeGenerator\Utils;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ConfirmationQuestion;
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
    $questions['service_name']->setValidator([Utils::class, 'validateServiceName']);

    $default_class = function ($vars) {
      $service = preg_replace('/^' . $vars['machine_name'] . '/', '', $vars['service_name']);
      return Utils::camelize($service);
    };
    $questions['class'] = new Question('Class', $default_class);
    $questions['class']->setValidator([Utils::class, 'validateClassName']);

    $this->collectVars($input, $output, $questions);

    $di_question = new ConfirmationQuestion('Would you like to inject dependencies?');
    if ($this->ask($input, $output, $di_question)) {
      $this->collectServices($input, $output);
    }

    $this->addFile()
      ->path('src/{class}.php')
      ->template('d8/service/custom.twig');

    $this->addServicesFile()
      ->template('d8/service/custom.services.twig');
  }

}
