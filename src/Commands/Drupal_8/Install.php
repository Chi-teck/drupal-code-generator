<?php

namespace DrupalCodeGenerator\Commands\Drupal_8;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use DrupalCodeGenerator\Commands\BaseGenerator;

/**
 * Implements d8:install command.
 */
class Install extends BaseGenerator {

  protected $name = 'd8:install';
  protected $description = 'Generates an install file';

  /**
   * {@inheritdoc}
   */
  protected function interact(InputInterface $input, OutputInterface $output) {

    $questions = [
      'name' => ['Module name', [$this, 'defaultName']],
      'machine_name' => ['Module machine name', [$this, 'defaultMachineName']],
    ];
    $vars = $this->collectVars($input, $output, $questions);

    $this->files[$vars['machine_name'] . '.install'] = $this->render('d8/install.twig', $vars);
  }

}
