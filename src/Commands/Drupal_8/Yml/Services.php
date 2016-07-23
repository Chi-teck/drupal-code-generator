<?php

namespace DrupalCodeGenerator\Commands\Drupal_8\Yml;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use DrupalCodeGenerator\Commands\BaseGenerator;

/**
 * Implements d8:yml:services command.
 */
class Services extends BaseGenerator {

  protected $name = 'd8:yml:services';
  protected $description = 'Generates a services yml file';
  protected $alias = 'services.yml';

  /**
   * {@inheritdoc}
   */
  protected function interact(InputInterface $input, OutputInterface $output) {

    $questions = [
      'name' => ['Module name', [$this, 'defaultName']],
      'machine_name' => ['Module machine name', [$this, 'defaultMachineName']],
    ];

    $vars = $this->collectVars($input, $output, $questions);
    $vars['class'] = $this->human2class($vars['name']);
    $this->files[$vars['machine_name'] . '.services.yml'] = $this->render('d8/yml/services.yml.twig', $vars);
  }

}
