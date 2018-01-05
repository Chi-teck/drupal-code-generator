<?php

namespace DrupalCodeGenerator\Command\Drupal_8\Test;

use DrupalCodeGenerator\Command\BaseGenerator;
use DrupalCodeGenerator\Utils;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;

/**
 * Implements d8:test:browser command.
 */
class Browser extends BaseGenerator {

  protected $name = 'd8:test:browser';
  protected $description = 'Generates a browser based test';
  protected $alias = 'browser-test';

  /**
   * {@inheritdoc}
   */
  protected function interact(InputInterface $input, OutputInterface $output) {
    $questions = Utils::defaultQuestions();
    $questions['class'] = new Question('Class', 'ExampleTest');
    $questions['class']->setValidator([Utils::class, 'validateClassName']);

    $this->collectVars($input, $output, $questions);

    $this->addFile()
      ->path('tests/src/Functional/{class}.php')
      ->template('d8/test/browser.twig');
  }

}
