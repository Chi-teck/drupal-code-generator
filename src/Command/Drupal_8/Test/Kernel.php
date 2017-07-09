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

    $vars = $this->collectVars($input, $output, $questions);

    $path = 'tests/src/Kernel/' . $vars['class'] . '.php';
    $this->setFile($path, 'd8/test/kernel.twig', $vars);
  }

}
