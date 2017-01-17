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

  /**
   * {@inheritdoc}
   */
  protected function interact(InputInterface $input, OutputInterface $output) {
    // Ask the user some questions.
    $questions = Utils::defaultQuestions() + [
      'description' => ['Module description', 'TODO: Write description for the module'],
      'package' => ['Package', 'custom'],
      'version' => ['Version', '7.x-1.0-dev'],
    ];
    $vars = $this->collectVars($input, $output, $questions);

    // @DCG: {
    // Instead of rendering this core DCG template you most likely need
    // to define own one. All custom templates should be situated under
    // the $HOME/.dcg/Templates directory. Notice that those templates
    // take precedence over the core DCG templates. So that it is not
    // necessary to create custom command to override default DCG
    // templates. However if you want to put some logic behind the
    // questions creating custom generator command is needed.
    // @DCG: }
    $this->files[$vars['machine_name'] . '.info'] = $this->render('d7/module-info.twig', $vars);
  }

}
