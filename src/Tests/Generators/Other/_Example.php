<?php

// @DCG: This file should be placed under $HOME/.dcg/Commands/custom directory.

namespace DrupalCodeGenerator\Commands\custom;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use DrupalCodeGenerator\Commands\BaseGenerator;

/**
 * Implements custom:example command.
 */
class Example extends BaseGenerator {

  protected $name = 'custom:example';
  protected $description = 'Some description';
  protected $alias = 'example';

  /**
   * {@inheritdoc}
   */
  protected function interact(InputInterface $input, OutputInterface $output) {

    // Ask the user some questions.
    $questions = [
      'name' => ['Module name', [$this, 'defaultName']],
      'machine_name' => ['Module machine name', [$this, 'defaultMachineName']],
    ];
    $vars = $this->collectVars($input, $output, $questions);

    // @DCG: {
    // Instead of rendering this core DCG template you most likely need
    // to define own one. All custom templates should be situated under
    // the $HOME/.dcg/Resources/templates directory. Notice that those
    // templates take precedence over the core DCG templates. So that
    // it is not necessary to create custom command to override default
    // DCG templates. However if you want to put some logic behind the
    // questions creating custom generator command is needed.
    // @DCG: }
    $this->files[$vars['machine_name'] . '.module'] = $this->render('d7/module.twig', $vars);

  }

}
