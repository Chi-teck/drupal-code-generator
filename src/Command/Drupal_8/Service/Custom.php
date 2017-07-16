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

  /**
   * {@inheritdoc}
   */
  protected function interact(InputInterface $input, OutputInterface $output) {
    $questions = Utils::defaultQuestions();
    $default_service_name = function ($vars) {
      return $vars['machine_name'] . '.example';
    };
    $questions['service_name'] = new Question('Service name', $default_service_name);
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

    $vars = $this->collectVars($input, $output, $questions);

    $this->setFile('src/' . $vars['class'] . '.php', 'd8/service/custom.twig', $vars);
    $this->setServicesFile($vars['machine_name'] . '.services.yml', 'd8/service/custom.services.twig', $vars);
  }

}
