<?php

namespace DrupalCodeGenerator\Command\Drupal_8\Service;

use DrupalCodeGenerator\Command\ModuleGenerator;
use DrupalCodeGenerator\Utils;
use Symfony\Component\Console\Question\Question;

/**
 * Implements d8:service:breadcrumb-builder command.
 */
class BreadcrumbBuilder extends ModuleGenerator {

  protected $name = 'd8:service:breadcrumb-builder';
  protected $description = 'Generates a breadcrumb builder service';
  protected $alias = 'breadcrumb-builder';

  /**
   * {@inheritdoc}
   */
  protected function generate() :void {
    $questions = Utils::moduleQuestions();
    $default_class = function ($vars) {
      return Utils::camelize($vars['name']) . 'BreadcrumbBuilder';
    };
    $questions['class'] = new Question('Class', $default_class);

    $this->collectVars($questions);

    $this->addFile()
      ->path('src/{class}.php')
      ->template('d8/service/breadcrumb-builder.twig');

    $this->addServicesFile()
      ->path('{machine_name}.services.yml')
      ->template('d8/service/breadcrumb-builder.services.twig');
  }

}
