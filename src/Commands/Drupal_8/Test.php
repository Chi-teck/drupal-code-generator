<?php

namespace DrupalCodeGenerator\Commands\Drupal_8;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use DrupalCodeGenerator\Commands\BaseGenerator;

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

    $questions = [
      'name' => ['Module name'],
      'machine_name' => ['Module machine name'],
      'test_name' => ['Test name', 'Example'],
    ];
    $vars = $this->collectVars($input, $output, $questions);
    $vars['class'] = $this->human2class($vars['test_name'] . 'Test');

    $this->files[$vars['class'] . '.php'] = $this->render('d8/test.twig', $vars);
  }

}
