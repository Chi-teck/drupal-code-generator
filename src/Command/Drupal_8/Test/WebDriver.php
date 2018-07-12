<?php

namespace DrupalCodeGenerator\Command\Drupal_8\Test;

use DrupalCodeGenerator\Command\BaseGenerator;
use DrupalCodeGenerator\Utils;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;

/**
 * Implements d8:test:webdriver command.
 */
class WebDriver extends BaseGenerator {

  protected $name = 'd8:test:webdriver';
  protected $description = 'Generates a test that supports JavaScript';
  protected $alias = 'webdriver-test';
  protected $label = 'WebDriver';

  /**
   * {@inheritdoc}
   */
  protected function interact(InputInterface $input, OutputInterface $output) {
    $questions = Utils::defaultQuestions();
    $questions['class'] = new Question('Class', 'ExampleTest');
    $questions['class']->setValidator([Utils::class, 'validateClassName']);

    $this->collectVars($input, $output, $questions);

    $this->addFile()
      ->path('tests/src/FunctionalJavascript/{class}.php')
      ->template('d8/test/webdriver.twig');
  }

}
