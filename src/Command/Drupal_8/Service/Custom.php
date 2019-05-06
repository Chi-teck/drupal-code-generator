<?php

namespace DrupalCodeGenerator\Command\Drupal_8\Service;

use DrupalCodeGenerator\Command\ModuleGenerator;
use DrupalCodeGenerator\Utils;
use Symfony\Component\Console\Question\Question;

/**
 * Implements d8:service:custom command.
 */
class Custom extends ModuleGenerator {

  protected $name = 'd8:service:custom';
  protected $description = 'Generates a custom Drupal service';
  protected $alias = 'custom-service';
  protected $label = 'Custom service';

  /**
   * {@inheritdoc}
   */
  protected function generate() :void {
    $questions = Utils::moduleQuestions();
    $questions['service_name'] = new Question('Service name', '{machine_name}.example');
    $questions['service_name']->setValidator([Utils::class, 'validateServiceName']);

    $default_class = function ($vars) {
      $service = preg_replace('/^' . $vars['machine_name'] . '/', '', $vars['service_name']);
      return Utils::camelize($service);
    };
    $questions['class'] = new Question('Class', $default_class);
    $questions['class']->setValidator([Utils::class, 'validateClassName']);

    $this->collectVars($questions);

    if ($this->confirm('Would you like to inject dependencies?')) {
      $this->collectServices();
    }

    $this->addFile()
      ->path('src/{class}.php')
      ->template('d8/service/custom.twig');

    $this->addServicesFile()
      ->template('d8/service/custom.services.twig');
  }

}
