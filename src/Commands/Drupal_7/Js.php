<?php

namespace DrupalCodeGenerator\Commands\Drupal_7;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use DrupalCodeGenerator\Commands\BaseGenerator;

/**
 * Implements d7:js command.
 */
class Js extends BaseGenerator {

  protected $name = 'd7:js';
  protected $description = 'Generates Drupal 7 javascript file';

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
