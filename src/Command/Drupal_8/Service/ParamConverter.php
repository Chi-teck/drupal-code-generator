<?php

namespace DrupalCodeGenerator\Command\Drupal_8\Service;

use DrupalCodeGenerator\Command\BaseGenerator;
use DrupalCodeGenerator\Utils;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;

/**
 * Implements d8:service:param-converter command.
 */
class ParamConverter extends BaseGenerator {

  protected $name = 'd8:service:param-converter';
  protected $description = 'Generates a param converter service';
  protected $alias = 'param-converter';

  /**
   * {@inheritdoc}
   */
  protected function interact(InputInterface $input, OutputInterface $output) {
    $questions = Utils::defaultQuestions();
    $questions['parameter_type'] = new Question('Parameter type', 'example');
    $default_class = function ($vars) {
      return Utils::camelize($vars['parameter_type']) . 'ParamConverter';
    };
    $questions['class'] = new Question('Class', $default_class);

    $vars = &$this->collectVars($input, $output, $questions);
    $vars['controller_class'] = Utils::camelize($vars['machine_name']) . 'Controller';

    $this->addFile()
      ->path('src/{class}.php')
      ->template('d8/service/param-converter.twig');

    $this->addServicesFile()
      ->path('{machine_name}.services.yml')
      ->template('d8/service/param-converter.services.twig');
  }

}
