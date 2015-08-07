<?php

namespace DrupalCodeGenerator\Commands\Drupal_7\Component;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use DrupalCodeGenerator\Commands\BaseGenerator;

/**
 * Implements generate:d7:component:module-file command.
 */
class Module extends BaseGenerator {

  protected static $name = 'd7:component:module-file';
  protected static $description = 'Generate Drupal 7 module file';

  /**
   * {@inheritdoc}
   */
  protected function interact(InputInterface $input, OutputInterface $output) {

    $questions = [
      'name' => ['Module name', [$this, 'defaultName']],
      'machine_name' => ['Module machine name', [$this, 'defaultMachineName']],
    ];

    $vars = $this->collectVars($input, $output, $questions);
    $this->files[$vars['machine_name'] . '.module'] = $this->render('d7/module.twig', $vars);

  }

}
