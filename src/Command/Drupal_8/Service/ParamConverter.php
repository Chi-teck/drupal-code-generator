<?php

namespace DrupalCodeGenerator\Command\Drupal_8\Service;

use DrupalCodeGenerator\Command\ModuleGenerator;
use DrupalCodeGenerator\Utils;
use Symfony\Component\Console\Question\Question;

/**
 * Implements d8:service:param-converter command.
 */
class ParamConverter extends ModuleGenerator {

  protected $name = 'd8:service:param-converter';
  protected $description = 'Generates a param converter service';
  protected $alias = 'param-converter';

  /**
   * {@inheritdoc}
   */
  protected function generate() :void {
    $questions = Utils::moduleQuestions();
    $questions['parameter_type'] = new Question('Parameter type', 'example');
    $default_class = function ($vars) {
      return Utils::camelize($vars['parameter_type']) . 'ParamConverter';
    };
    $questions['class'] = new Question('Class', $default_class);

    $vars = &$this->collectVars($questions);
    $vars['controller_class'] = Utils::camelize($vars['machine_name']) . 'Controller';

    $this->addFile()
      ->path('src/{class}.php')
      ->template('d8/service/param-converter.twig');

    $this->addServicesFile()
      ->path('{machine_name}.services.yml')
      ->template('d8/service/param-converter.services.twig');
  }

}
