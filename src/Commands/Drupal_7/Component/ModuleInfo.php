<?php

namespace DrupalCodeGenerator\Commands\Drupal_7\Component;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use DrupalCodeGenerator\Commands\BaseGenerator;

/**
 * Implements generate:d7:component:info-file command.
 */
class ModuleInfo extends BaseGenerator {

  protected $name = 'd7:component:module-info-file';
  protected $description = 'Generate Drupal 7 info file for a module.';

  /**
   * {@inheritdoc}
   */
  protected function interact(InputInterface $input, OutputInterface $output) {

    $questions = [
      'name' => ['Module name', [$this, 'defaultName']],
      'machine_name' => ['Module machine name', [$this, 'defaultMachineName']],
      'description' => ['Module description', 'TODO: Write description for the module'],
      'package' => ['Package', 'custom'],
      'version' => ['Version', '7.x-1.0-dev'],
    ];

    $vars = $this->collectVars($input, $output, $questions);

    $prefix = $vars['machine_name'];
    $this->files[$prefix . '.info'] = $this->render('d7/module-info.twig', $vars);

  }

}
