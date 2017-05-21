<?php

// @DCG: This file should be placed under $HOME/.dcg/Commands/custom directory.

namespace DrupalCodeGenerator\Commands\custom;

use DrupalCodeGenerator\Commands\BaseGenerator;
use DrupalCodeGenerator\Utils;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

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
      'description' => ['Module description'],
      'package' => ['Package', 'custom'],
      'version' => ['Version', '7.x-1.0-dev'],
    ];
    $vars = $this->collectVars($input, $output, $questions);

    $this->files[$vars['machine_name'] . '.info'] = $this->render('module-info.twig', $vars);
  }

}
