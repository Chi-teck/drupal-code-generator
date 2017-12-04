<?php

namespace DrupalCodeGenerator\Command\Drupal_8\Service;

use DrupalCodeGenerator\Command\BaseGenerator;
use DrupalCodeGenerator\Utils;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;

/**
 * Implements d8:service:access-checker command.
 */
class AccessChecker extends BaseGenerator {

  protected $name = 'd8:service:access-checker';
  protected $description = 'Generates an access checker service';
  protected $alias = 'access-checker';

  /**
   * {@inheritdoc}
   */
  protected function interact(InputInterface $input, OutputInterface $output) {
    $questions = Utils::defaultQuestions();
    $questions['applies_to'] = new Question('Applies to', '_foo');
    $questions['applies_to']->setValidator(function ($value) {
      if (!preg_match('/^_[a-z0-9_]*[a-z0-9]$/', $value)) {
        throw new \UnexpectedValueException('The value is not correct name for "applies_to" property.');
      }
      return $value;
    });
    $default_class = function ($vars) {
      return Utils::camelize($vars['applies_to'] . 'AccessChecker');
    };
    $questions['class'] = new Question('Class', $default_class);

    $this->collectVars($input, $output, $questions);

    $this->addFile()
      ->path('src/Access/{class}.php')
      ->template('d8/service/access-checker.twig');

    $this->addServicesFile()
      ->template('d8/service/access-checker.services.twig');
  }

}
