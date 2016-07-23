<?php

namespace DrupalCodeGenerator\Commands\Drupal_8\Yml;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use DrupalCodeGenerator\Commands\BaseGenerator;

/**
 * Implements d8:yml:libraries command.
 */
class Libraries extends BaseGenerator {

  protected $name = 'd8:yml:libraries';
  protected $description = 'Generates a libraries yml file';
  protected $alias = 'libraries.yml';

  /**
   * {@inheritdoc}
   */
  protected function interact(InputInterface $input, OutputInterface $output) {

    $questions = [
      'name' => ['Module name', [$this, 'defaultName']],
      'machine_name' => ['Module machine name', [$this, 'defaultMachineName']],
      'project_type' => ['Project type (module/theme)', 'module'],
    ];
    $vars = $this->collectVars($input, $output, $questions);
    $this->files[$vars['machine_name'] . '.libraries.yml'] = $this->render('d8/yml/libraries.yml.twig', $vars);
  }

}
