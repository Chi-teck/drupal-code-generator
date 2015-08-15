<?php

namespace DrupalCodeGenerator\Commands\Drupal_6\Component;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use DrupalCodeGenerator\Commands\BaseGenerator;

/**
 * Implements d6:component:module-info command.
 */
class ModuleInfo extends BaseGenerator {

  protected $name = 'd6:component:module-info';
  protected $description = 'Generate Drupal 6 info file (module)';

  /**
   * {@inheritdoc}
   */
  protected function interact(InputInterface $input, OutputInterface $output) {

    $questions = [
      'name' => ['Module name', [$this, 'defaultName']],
      'machine_name' => ['Module machine name', [$this, 'defaultMachineName']],
      'description' => ['Module description', 'TODO: Write description for the module'],
      'package' => ['Package', 'custom'],
      'version' => ['Version', '6.x-1.0-dev'],
    ];

    $vars = $this->collectVars($input, $output, $questions);
    $this->files[$vars['machine_name'] . '.info'] = $this->render('d6/module-info.twig', $vars);

  }

}
