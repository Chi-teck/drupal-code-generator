<?php

namespace DrupalCodeGenerator\Commands\Drupal_8;

use DrupalCodeGenerator\Commands\BaseGenerator;
use DrupalCodeGenerator\Commands\Utils;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Implements d8:test command.
 */
class Test extends BaseGenerator {

  protected $name = 'd8:test';
  protected $description = 'Generates a test';
  protected $alias = 'test';

  /**
   * {@inheritdoc}
   */
  protected function interact(InputInterface $input, OutputInterface $output) {
    $questions = Utils::defaultQuestions() + [
      'test_name' => ['Test name', 'Example'],
    ];
    $vars = $this->collectVars($input, $output, $questions);
    $vars['class'] = Utils::human2class($vars['test_name'] . 'Test');
    $this->files[$vars['class'] . '.php'] = $this->render('d8/test.twig', $vars);
  }

}
