<?php

namespace DrupalCodeGenerator\Commands\Drupal_8;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use DrupalCodeGenerator\Commands\BaseGenerator;

/**
 * Implements d8:module-file command.
 */
class ModuleFile extends BaseGenerator {

  protected $name = 'd8:module-file';
  protected $description = 'Generates a module file';

  /**
   * {@inheritdoc}
   */
  protected function interact(InputInterface $input, OutputInterface $output) {
    $questions = [
      'name' => ['Theme name', [$this, 'defaultName']],
      'machine_name' => ['Theme machine name', [$this, 'defaultMachineName']],
    ];
    $vars = $this->collectVars($input, $output, $questions);

    $this->files[$vars['machine_name'] . '.module'] = $this->render('d8/module.twig', $vars);
  }

}
