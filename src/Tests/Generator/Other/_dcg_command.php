<?php

// @DCG This file should be placed under $HOME/.dcg/Command/custom directory.

namespace DrupalCodeGenerator\Command\custom;

use DrupalCodeGenerator\Command\BaseGenerator;
use DrupalCodeGenerator\Utils;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;

/**
 * Implements custom:example command.
 */
class Example extends BaseGenerator {

  protected $name = 'custom:example';
  protected $description = 'Some description';
  protected $alias = 'example';
  protected $templatePath = __DIR__;

  /**
   * {@inheritdoc}
   */
  protected function interact(InputInterface $input, OutputInterface $output) {
    // Ask the user some questions.
    $questions = Utils::defaultQuestions();
    $default_class = function ($vars) {
      return Utils::camelize($vars['name'] . 'Example');
    };
    $questions['class'] = new Question('Class', $default_class);
    $vars = $this->collectVars($input, $output, $questions);

    // @DCG The template should be created under $self::templatePath directory.
    $this->setFile('src/' . $vars['class'] . '.php', 'example.twig', $vars);
  }

}
