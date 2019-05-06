<?php

namespace DrupalCodeGenerator\Command\Drupal_8\Test;

use DrupalCodeGenerator\Command\ModuleGenerator;
use DrupalCodeGenerator\Utils;
use Symfony\Component\Console\Question\Question;

/**
 * Implements d8:test:nightwatch command.
 */
class Nightwatch extends ModuleGenerator {

  protected $name = 'd8:test:nightwatch';
  protected $description = 'Generates a nightwatch test';
  protected $alias = 'nightwatch-test';

  /**
   * {@inheritdoc}
   */
  protected function generate() :void {
    $questions = Utils::moduleQuestions();
    $questions['test_name'] = new Question('Test name', 'example');

    $vars = &$this->collectVars($questions);
    $vars['test_name'] = Utils::camelize($vars['test_name'], FALSE);

    $this->addFile()
      ->path('tests/src/Nightwatch/{test_name}Test.js')
      ->template('d8/test/nightwatch.twig');
  }

}
