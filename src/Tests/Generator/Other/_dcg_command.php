<?php

// @DCG: This file should be placed under $HOME/.dcg/Command/custom directory.

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
    $questions = Utils::defaultQuestions() + [
      'description' => new Question('Module description'),
      'package' => new Question('Package', 'custom'),
      'version' => new Question('Version', '7.x-1.0-dev'),
    ];
    $vars = $this->collectVars($input, $output, $questions);

    // @DCG: The template should be created under $self::templatePath directory.
    $this->setFile($vars['machine_name'] . '.info', 'module-info.twig', $vars);
  }

}
