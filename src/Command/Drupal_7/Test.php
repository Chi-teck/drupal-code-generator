<?php

namespace DrupalCodeGenerator\Command\Drupal_7;

use DrupalCodeGenerator\Command\BaseGenerator;
use DrupalCodeGenerator\Utils;
use Symfony\Component\Console\Question\Question;

/**
 * Implements d7:test command.
 */
class Test extends BaseGenerator {

  protected $name = 'd7:test';
  protected $description = 'Generates Drupal 7 test case';

  /**
   * {@inheritdoc}
   */
  protected function generate() :void {
    $questions = Utils::moduleQuestions();
    $default_class = function ($vars) {
      return Utils::camelize($vars['machine_name']) . 'TestCase';
    };
    $questions['class'] = new Question('Class', $default_class);

    $this->collectVars($questions);

    $this->addFile()
      ->path('{machine_name}.test')
      ->template('d7/test.twig');
  }

}
