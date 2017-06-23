<?php

namespace DrupalCodeGenerator\Command\Drupal_7;

use DrupalCodeGenerator\Command\BaseGenerator;
use DrupalCodeGenerator\Utils;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;

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
    $questions = Utils::defaultQuestions();
    $default_class = function ($vars) {
      return Utils::camelize($vars['machine_name']) . 'TestCase';
    };
    $questions['class'] = new Question('Class', $default_class);
    $vars = $this->collectVars($input, $output, $questions);
    $this->setFile($vars['machine_name'] . '.test', 'd7/test.twig', $vars);
  }

}
