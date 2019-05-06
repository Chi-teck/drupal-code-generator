<?php

namespace DrupalCodeGenerator\Command\Drupal_8\Test;

use DrupalCodeGenerator\Command\ModuleGenerator;
use DrupalCodeGenerator\Utils;
use Symfony\Component\Console\Question\Question;

/**
 * Implements d8:test:webdriver command.
 */
class WebDriver extends ModuleGenerator {

  protected $name = 'd8:test:webdriver';
  protected $description = 'Generates a test that supports JavaScript';
  protected $alias = 'webdriver-test';
  protected $label = 'WebDriver';

  /**
   * {@inheritdoc}
   */
  protected function generate() :void {
    $questions = Utils::moduleQuestions();
    $questions['class'] = new Question('Class', 'ExampleTest');
    $questions['class']->setValidator([Utils::class, 'validateClassName']);

    $this->collectVars($questions);

    $this->addFile()
      ->path('tests/src/FunctionalJavascript/{class}.php')
      ->template('d8/test/webdriver.twig');
  }

}
