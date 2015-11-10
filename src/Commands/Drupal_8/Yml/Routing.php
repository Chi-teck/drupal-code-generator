<?php

namespace DrupalCodeGenerator\Commands\Drupal_8\Yml;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use DrupalCodeGenerator\Commands\BaseGenerator;

/**
 * Implements d8:yml:routing command.
 */
class Routing extends BaseGenerator {

  protected $name = 'd8:yml:routing';
  protected $description = 'Generates a routing yml file';

  /**
   * {@inheritdoc}
   */
  protected function interact(InputInterface $input, OutputInterface $output) {

    $questions = [
      'name' => ['Module name', [$this, 'defaultName']],
      'machine_name' => ['Module machine name', [$this, 'defaultMachineName']],
    ];
    $vars = $this->collectVars($input, $output, $questions);

    $vars['class'] = $this->human2class($vars['name'] . 'Controller');
    $this->files[$vars['machine_name'] . '.routing.yml'] = $this->render('d8/routing.yml.twig', $vars);
  }

}
