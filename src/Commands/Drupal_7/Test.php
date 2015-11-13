<?php

namespace DrupalCodeGenerator\Commands\Drupal_7;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use DrupalCodeGenerator\Commands\BaseGenerator;

/**
 * Implements d7:test command.
 */
class Test extends BaseGenerator {

  protected $name = 'd7:test';
  protected $description = 'Generates Drupal 7 test case';

  /**
   * {@inheritdoc}
   */
  protected function interact(InputInterface $input, OutputInterface $output) {
    $questions = [
      'name' => ['Module name', [$this, 'defaultName']],
      'machine_name' => ['Module machine name', [$this, 'defaultMachineName']],
      'class' => ['Class', [$this, 'defaultClass']],
    ];
    $vars = $this->collectVars($input, $output, $questions);

    $this->files[$vars['machine_name'] . '.test'] = $this->render('d7/test.twig', $vars);
  }

  /**
   * Returns default value for the class question.
   */
  protected function defaultClass($vars) {
    return $this->human2class($vars['machine_name']) . 'TestCase';
  }

}
