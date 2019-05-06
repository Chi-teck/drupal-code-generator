<?php

namespace DrupalCodeGenerator\Command\Drupal_8\Test;

use DrupalCodeGenerator\Command\ModuleGenerator;
use DrupalCodeGenerator\Utils;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;

/**
 * Implements d8:test:web command.
 */
class Web extends ModuleGenerator {

  protected $name = 'd8:test:web';
  protected $description = 'Generates a web based test';
  protected $alias = 'web-test';
  protected $label = 'Web (simpletest)';

  /**
   * {@inheritdoc}
   */
  protected function interact(InputInterface $input, OutputInterface $output) :void {
    $questions = Utils::moduleQuestions();
    $questions['class'] = new Question('Class', 'ExampleTest');
    $questions['class']->setValidator([Utils::class, 'validateClassName']);

    $this->collectVars($questions);

    $this->addFile()
      ->path('src/Tests/{class}.php')
      ->template('d8/test/web.twig');
  }

}
