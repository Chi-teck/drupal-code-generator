<?php

namespace DrupalCodeGenerator\Command\Drupal_8\Test;

use DrupalCodeGenerator\Command\BaseGenerator;
use DrupalCodeGenerator\Utils;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;

/**
 * Implements d8:test:kernel command.
 */
class Kernel extends BaseGenerator {

  protected $name = 'd8:test:kernel';
  protected $description = 'Generates a kernel based test';
  protected $alias = 'kernel-test';

  /**
   * {@inheritdoc}
   */
  protected function interact(InputInterface $input, OutputInterface $output) {
    $questions = Utils::defaultQuestions();
    $questions['class'] = new Question('Class', 'ExampleTest');
    $questions['class']->setValidator([Utils::class, 'validateClassName']);

    $this->collectVars($input, $output, $questions);

    $this->addFile()
      ->path('tests/src/Kernel/{class}.php')
      ->template('d8/test/kernel.twig');
  }

}
