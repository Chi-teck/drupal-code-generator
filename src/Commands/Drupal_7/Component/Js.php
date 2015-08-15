<?php

namespace DrupalCodeGenerator\Commands\Drupal_7\Component;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use DrupalCodeGenerator\Commands\BaseGenerator;

/**
 * Implements d7:component:js command.
 */
class Js extends BaseGenerator {

  protected $name = 'd7:component:js';
  protected $description = 'Generate Drupal 7 javascript file';

  /**
   * {@inheritdoc}
   */
  protected function interact(InputInterface $input, OutputInterface $output) {

    $questions = [
      'name' => ['Module name', [$this, 'defaultName']],
      'machine_name' => ['Module machine name', [$this, 'defaultMachineName']],
    ];

    $vars = $this->collectVars($input, $output, $questions);
    $vars['project_type'] = 'module';

    $this->files[$vars['machine_name'] . '.js'] = $this->render('d7/js.twig', $vars);

  }

}
