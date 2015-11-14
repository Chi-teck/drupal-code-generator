<?php

namespace DrupalCodeGenerator\Commands\Drupal_8;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use DrupalCodeGenerator\Commands\BaseGenerator;

/**
 * Implements d8:javascript command.
 */
class Javascript extends BaseGenerator {

  protected $name = 'd8:javascript';
  protected $description = 'Generates Drupal 8 javascript file';

  /**
   * {@inheritdoc}
   */
  protected function interact(InputInterface $input, OutputInterface $output) {

    $questions = [
      'name' => ['Module name', [$this, 'defaultName']],
      'machine_name' => ['Module machine name', [$this, 'defaultMachineName']],
    ];

    $vars = $this->collectVars($input, $output, $questions);
    $path = $this->createPath('js/', $vars['machine_name'] . '.js', $vars['machine_name']);

    $this->files[$path] = $this->render('d8/javascript.twig', $vars);

  }

}
