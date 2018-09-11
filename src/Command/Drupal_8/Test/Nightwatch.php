<?php

namespace DrupalCodeGenerator\Command\Drupal_8\Test;

use DrupalCodeGenerator\Command\BaseGenerator;
use DrupalCodeGenerator\Utils;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;

/**
 * Implements d8:test:nightwatch command.
 */
class Nightwatch extends BaseGenerator {

  protected $name = 'd8:test:nightwatch';
  protected $description = 'Generates a nightwatch test';
  protected $alias = 'nightwatch-test';

  /**
   * {@inheritdoc}
   */
  protected function interact(InputInterface $input, OutputInterface $output) {
    $questions = Utils::defaultQuestions();
    $questions['test_name'] = new Question('Test name', 'example');

    $vars = &$this->collectVars($input, $output, $questions);
    $vars['test_name'] = Utils::camelize($vars['test_name'], FALSE);

    $this->addFile()
      ->path('tests/src/Nightwatch/{test_name}Test.js')
      ->template('d8/test/nightwatch.twig');
  }

}
