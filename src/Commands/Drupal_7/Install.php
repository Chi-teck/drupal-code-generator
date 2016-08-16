<?php

namespace DrupalCodeGenerator\Commands\Drupal_7;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use DrupalCodeGenerator\Commands\BaseGenerator;

/**
 * Implements d7:install command.
 */
class Install extends BaseGenerator {

  protected $name = 'd7:install';
  protected $description = 'Generates Drupal 7 install file';

  /**
   * {@inheritdoc}
   */
  protected function interact(InputInterface $input, OutputInterface $output) {

    $questions = [
      'name' => ['Module name'],
      'machine_name' => ['Module machine name'],
    ];

    $vars = $this->collectVars($input, $output, $questions);
    $this->files[$vars['machine_name'] . '.install'] = $this->render('d7/install.twig', $vars);

  }

}
