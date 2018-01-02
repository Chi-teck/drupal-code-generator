<?php

namespace DrupalCodeGenerator\Command\Drupal_8\Service;

use DrupalCodeGenerator\Command\BaseGenerator;
use DrupalCodeGenerator\Utils;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;

/**
 * Implements d8:service:breadcrumb-builder command.
 */
class BreadcrumbBuilder extends BaseGenerator {

  protected $name = 'd8:service:breadcrumb-builder';
  protected $description = 'Generates a breadcrumb builder service';
  protected $alias = 'breadcrumb-builder';

  /**
   * {@inheritdoc}
   */
  protected function interact(InputInterface $input, OutputInterface $output) {
    $questions = Utils::defaultQuestions();
    $default_class = function ($vars) {
      return Utils::camelize($vars['name'] . 'BreadcrumbBuilder');
    };
    $questions['class'] = new Question('Class', $default_class);

    $this->collectVars($input, $output, $questions);

    $this->addFile()
      ->path('src/{class}.php')
      ->template('d8/service/breadcrumb-builder.twig');

    $this->addServicesFile()
      ->path('{machine_name}.services.yml')
      ->template('d8/service/breadcrumb-builder.services.twig');
  }

}
