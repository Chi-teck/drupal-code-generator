<?php

namespace DrupalCodeGenerator\Commands\Drupal_8\Yml;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use DrupalCodeGenerator\Commands\BaseGenerator;

/**
 * Implements d8:yml:permissions command.
 */
class Permissions extends BaseGenerator {

  protected $name = 'd8:yml:permissions';
  protected $description = 'Generates a permissions yml file';
  protected $alias = 'permissions.yml';

  /**
   * {@inheritdoc}
   */
  protected function interact(InputInterface $input, OutputInterface $output) {

    $questions = [
      'name' => ['Module name', [$this, 'defaultName']],
      'machine_name' => ['Module machine name', [$this, 'defaultMachineName']],
    ];
    $vars = $this->collectVars($input, $output, $questions);

    $this->files[$vars['machine_name'] . '.permissions.yml'] = $this->render('d8/yml/permissions.yml.twig', $vars);
  }

}
